<?php

require_once __DIR__ . '/regex.php';

function isOfType($type, $value) {
    $types = explode('|', $type);
    foreach($types as $t) {
        if(gettype($value) === $type) {
            return true;
        }
    }
    return false;
}

class ValidationRule {
    public $validator;

    public $field;
    public $isRequired = false;
    private $shouldBePassword = false;
    private $shouldBeEmail = false;
    private $shouldBePseudo = false;
    private $shouldBeOfType = false;

    private $minLength = false;
    private $maxLength = false;

    private $errorsArray = [];

    function __construct($field) {
        $this->field = $field;

        return $this;
    }


    // méthodes de règle
    static public function make($field) {
        return new static($field);
    }

    static public function required($field) {
        return static::make($field)->setIsRequired(true);
    }

    static public function optionnal($field) {
        return static::make($field)->setIsRequired(false);
    }


    
    public function minLength($min) { 
        $this->string();
        $this->minLength = $min; 
        return $this;
    }
    public function maxLength($max) { 
        $this->string();
        $this->maxLength = $max; 
        return $this;
    }

    public function string() {
        $this->shouldBeOfType = "string";
        return $this;
    }

    public function pseudo() {
        $this->shouldBePseudo = true;
        return $this;
    }

    public function password() {
        $this->shouldBePassword = true;
        return $this;
    }

    public function email() {
        $this->shouldBeEmail = true;
        return $this;
    }

    // fin méthodes de règles

    public function isValid() {
        if($this->isRequired) {
            if(
                $this->getValue() === NULL
                OR empty($this->validator->fieldsValues[$this->field])
            ) {
                $this->addError(':field est requis');
                return false;
            }
        }

        if($this->shouldBeOfType) {
            if(!isOfType($this->shouldBeOfType, $this->getValue())) {
                $this->addError(':field doit être de type :shouldBeOfType');
                return false;
            }
        }

        if($this->shouldBePseudo) {
            // isPseudo est une fonction utilitaire
            if(!isPseudo($this->getValue())) {
                $this->addError(':field doit être un pseudo');
                return false;
            }
        }

        if($this->shouldBePassword) {
            // isPassword est une fonction utilitaire
            if(!isPassWord($this->getValue())) {
                $this->addError(':field doit être un mot de passe');
                return false;
            }
        }

        if($this->shouldBeEmail) {
            // isEmail est une fonction utilitaire
            if(!isEmail($this->getValue())) {
                $this->addError(':field doit être un email');
                return false;
            }
        }

        if($this->minLength) {
            if(strlen($this->getValue()) < $this->minLength) {
                $this->addError(':field doit avoir une longueur d\'au moins :minLength');
                return false;
            }
        }

        if($this->maxLength) {
            if(strlen($this->getValue()) > $this->maxLength) {
                $this->addError(':field doit avoir une longueur de maximum :maxLength');
                return false;
            }
        }

        return true;
    }

    public function setValidator($validator) {
        $this->validator = $validator;

        return $this;
    }

    public function setIsRequired($isRequired) {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function isSameFieldName($ruleToCompare) {
        return $this->field === $ruleToCompare->field;
    }

    public function getValue() {
        if(isset($this->validator->fieldsValues[$this->field])) return $this->validator->fieldsValues[$this->field];
        return NULL;
    }

    public function addError($msg) {
        array_push(
            $this->errorsArray, 
            preg_replace_callback(
                "/:(\w+)/", 
                function($matches) {
                    return get_object_vars($this)[$matches[1]];
                }, 
                $msg
            )
        );
    }

    public function errors() {
        return $this->errorsArray;
    }
}

class Validator {
    public $rules = [];
    public $fieldsValues = [];

    public $tested = false;
    public $hasSucceeded = null;

    private $errorsArray = [];
    
    
    function __construct($rules) {
        foreach($rules as $newRule) {
            $this->addRule($newRule);
        }
    }

    /**
     * Crée un validator avec les règles passées
     * @param ValidatorRule $rules Les règles
     * @return Validator
     */
    static public function make($rules) {
        return new static($rules);
    }

    


    /**
     * Définit quel tableau associatif sera examiné
     * @return this
     */
    public function bindValues($fields) {
        $this->fieldsValues = $fields;
        return $this;
    }

    /**
     * Effectue la validation
     * Si toutes les règles définies sont respectées, alors le validator est content
     * @return bool
     */
    public function success() {
        $this->tested = true;

        $this->hasSucceeded = true;
        foreach($this->rules as $rule) {
            if( !$rule->isValid() ) {
                $this->hasSucceeded = false;
                $this->addErrors($rule->errors());
                break;
            }
        }

        return $this->hasSucceeded;
    }

    /**
     * Retourne la valeur vérifiée, passé dans la fonction ctrlSaisies()
     * Nécessite que le validator ait été validé via sa fonction success()
     */
    public function verifiedField($fieldName) {
        try {
            if(!$this->hasSucceeded) {
                throw new Error('Le validator n\'a pas été validée');
            }
            return ctrlSaisies($this->fieldsValues[$fieldName]);
        } catch(Error $e) {
			die('Erreur validator : ' . $e->getMessage());
        }
    }


    /**
     * Ajoute une règle au validator
     * @param ValidatorRule $potentialRule
     * @return this
     */
    public function addRule($potentialRule) {

        // vérifie que c'est bien une rule
        if($potentialRule instanceof ValidationRule) {
            
            // l'ajoute si elle n'existe pas déjà
            if( !$this->ruleExist($potentialRule) ) {
                array_push(
                    $this->rules, 
                    $potentialRule->setValidator($this)
                );
            } 
        }
        return $this;        
    }


    /**
     * Vérifie s'il y a conflit avec une règle sur un même field
     */
    private function ruleExist($ruleToCompare) {
        $searchResultCount = count(array_filter(
            $this->rules, 
            fn($rule)=>$rule->isSameFieldName($ruleToCompare)
        ));
        // s'il y a au moins un résultat, la règle existe
        $exists = $searchResultCount > 0;
        return $exists;
    }

    public function errors() {
        return $this->errorsArray;
    }

    private function addErrors($errors) {
        foreach($errors as $error) {
            array_push($this->errorsArray, $error);
        }
    }
} 