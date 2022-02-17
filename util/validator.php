<?php


class ValidationRule {
    public $validator;

    public $field;
    public $isRequired = false;
    public $shouldBePassword = false;
    public $shouldBeEmail = false;

    function __construct($field) {
        $this->field = $field;

        return $this;
    }

    static public function make($field) {
        return new static($field);
    }

    static public function required($field) {
        return static::make($field)->setIsRequired(true);
    }

    static public function optionnal($field) {
        return static::make($field)->setIsRequired(false);
    }
    
    public function password() {
        $this->shouldBePassword = true;
        return $this;
    }

    public function email() {
        $this->shouldBeEmail = true;
        return $this;
    }


    public function isValid() {
        if($this->isRequired) {
            if(
                $this->getValue() === NULL
                OR empty($this->validator->fieldsValues[$this->field])
            ) return false;
        }

        if($this->shouldBePassword) {
            if(!isPassWord($this->getValue())) return false;
        }

        if($this->shouldBeEmail) {
            if(!isEmail($this->getValue())) return false;
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
}

class Validator {
    public $rules = [];
    public $fieldsValues = [];

    public $tested = false;
    public $hasSucceeded = null;
    
    
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
                // break;
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
} 