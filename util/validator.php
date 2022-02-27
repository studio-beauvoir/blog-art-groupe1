<?php

// en v 2 v c'est un peu inutile de les ré inclure vu 
// qu'on se sert des utils via /util/index.php, qui inclut tout à la suite
// mais on fait ça dans le cas où on incluerait seulement le validator.php
require_once __DIR__ . '/regex.php';
require_once __DIR__ . '/ctrlUploadImage.php';

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
    public $isFilled = false;

    private $shouldBePassword = false;
    private $shouldBeEmail = false;
    private $shouldBePseudo = false;
    private $shouldBeImage = false;
    private $shouldBeOfType = false;
    private $shouldBeEqualTo = false;
    private $shouldBeEqualToValue = false;
    private $shouldBeUnique = false;

    private $minLength = false;
    private $maxLength = false;
    private $maxFileSize = false;

    private $errorMessage = [
        'isRequired' => ":field est requis",
        'shouldBePassword' => "Le mot de passe doit comporter entre 6 et 15 caractères, et au moins une lettre, un chiffre et un caractère spécial parmi &@#$%_-.?!",
        'shouldBeEmail' =>":field doit être un email",
        'shouldBePseudo' =>":field doit comporter entre 6 et 70 caractères",
        'shouldBeImage' =>":field doit être une image",
        'shouldBeOfType' => ":field doit être de type :shouldBeOfType",
        'shouldBeEqualTo' => ":field doit être identique au champ :shouldBeEqualTo",
        'shouldBeEqualToValue' => ":field doit être égal à :shouldBeEqualToValue",
        'shouldBeUnique' => ":field existe déjà",
        'minLength' => ":field ne doit pas faire moins de :minLength",
        'maxLength' => ":field ne doit pas faire plus de :maxLength",
        'maxFileSize' => ":field dépasse la taille autorisée",
    ];
    private $errorsArray = [];

    function __construct($field) {
        $this->field = $field;

        return $this;
    }


    public function customError($error, $message) {
        if(!isset($this->errorMessage[$error])) return $this;
        $this->errorMessage[$error] = $message;
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

    public function maxFileSize($max) {
        $this->maxFileSize = $max;
        return $this;
    }

    public function unique($table, $column=false, $exceptSelf=false) {
        $this->shouldBeUnique = [
            'table'=>$table,
            'column'=>$column?$column:$this->field,
            'exceptSelf'=>$exceptSelf,
        ];
        return $this;
    }

    public function string() {
        $this->shouldBeOfType = "string";
        return $this;
    }

    public function image() {
        $this->shouldBeImage = true;
        $this->maxFileSize(MAX_IMG_SIZE);
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

    public function equalTo($otherFieldName) {
        $this->shouldBeEqualTo = $otherFieldName;
        return $this;
    }

    public function equalToValue($value) {
        $this->shouldBeEqualToValue = $value;
        return $this;
    }

    // fin méthodes de règles

    public function isValid() {
        $isValid = true;
        if(
            $this->getValue() === NULL
            OR empty($this->validator->fieldsValues[$this->field])
            OR (is_array($this->getValue()) AND isset($this->getValue()['size']) AND $this->getValue()['size']===0)
        ) {
            if($this->isRequired) {
                $this->addError('isRequired');
                return false;
            } else {
                return true;
            }
        }
        
        $this->isFilled = true;
        $this->validator->fieldsFilled[$this->field] = true;

        if($this->shouldBeUnique) {
            // isPseudo est une fonction utilitaire (/util/db.php)
            if(!isUnique($this->shouldBeUnique['table'], $this->getValue(), $this->shouldBeUnique['column'], $this->shouldBeUnique['exceptSelf'])) {
                $this->addError('shouldBeUnique');
                $isValid = false;
            }
        }

        if($this->shouldBeOfType) {
            if(!isOfType($this->shouldBeOfType, $this->getValue())) {
                $this->addError('shouldBeOfType');
                $isValid = false;
            }
        }

        if($this->shouldBePseudo) {
            // isPseudo est une fonction utilitaire (/util/regex.php)
            if(!isPseudo($this->getValue())) {
                $this->addError('shouldBePseudo');
                $isValid = false;
            }
        }

        if($this->shouldBeImage) {
            // isPseudo et getExtensionsAllowed sont des fonctions utilitaires (/util/ctrlUploadImage.php)
            if(!isImage($this->getValue())) {
                $this->customError('shouldBeImage', ':field doit être une image de type '.implode(', ', getImageExtensionsAllowed()));
                $this->addError('shouldBeImage');
                $isValid = false;
            }
        }

        if($this->shouldBePassword) {
            // isPassword est une fonction utilitaire (/util/regex.php)
            if(!isPassWord($this->getValue())) {
                $this->addError('shouldBePassword');
                $isValid = false;
            }
        }

        if($this->shouldBeEmail) {
            // isEmail est une fonction utilitaire (/util/regex.php)
            if(!isEmail($this->getValue())) {
                $this->addError('shouldBeEmail');
                $isValid = false;
            }
        }

        if($this->minLength) {
            if(strlen($this->getValue()) < $this->minLength) {
                $this->addError('minLength');
                $isValid = false;
            }
        }

        if($this->maxLength) {
            if(strlen($this->getValue()) > $this->maxLength) {
                $this->addError('maxLength');
                $isValid = false;
            }
        }

        if($this->maxFileSize) {
            if(filesize($this->getValue()['tmp_name']) > $this->maxFileSize) {
                $this->customError('maxFileSize',':field doit peser maximum '.($this->maxFileSize/1000).'Ko');
                $this->addError('maxFileSize');
                $isValid = false;
            }
        }

        if($this->shouldBeEqualTo) {
            if($this->getValue($this->shouldBeEqualTo) !== $this->getValue()) {
                $this->addError('shouldBeEqualTo');
                $isValid = false;
            }
        }

        if($this->shouldBeEqualToValue) {
            if($this->shouldBeEqualToValue !== $this->getValue()) {
                $this->addError('shouldBeEqualToValue');
                $isValid = false;
            }
        }

        return $isValid;
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

    public function getValue($field=false) {
        $field = $field?$field:$this->field;
        if(isset($this->validator->fieldsValues[$field])) return $this->validator->fieldsValues[$field];
        return NULL;
    }

    public function addError($errorName) {
        array_push(
            $this->errorsArray, 
            preg_replace_callback(
                "/:(\w+)/", 
                function($matches) {
                    return get_object_vars($this)[$matches[1]];
                }, 
                $this->errorMessage[$errorName]
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
    public $fieldsFilled = [];

    public $tested = false;
    public $hasSucceeded = null;

    public $errorsArray = [];
    
    
    public function __construct($rules) {
        $this->addRules($rules);
        return $this;
    }

    /**
     * Crée un validator avec les règles passées
     * @param ValidatorRule $rules Les règles
     * @return Validator
     */
    static public function make($rules=[]) {
        return new static($rules);
    }


    public function addRules($rules) {
        foreach($rules as $newRule) {
            $this->addRule($newRule);
        }
        return $this;
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
     * @return this
     */
    public function test() {
        $this->tested = true;

        $this->hasSucceeded = true;
        foreach($this->rules as $rule) {
            if( !$rule->isValid() ) {
                $this->hasSucceeded = false;
                $this->addErrors($rule->errors());
            }
        }
        return $this;
    }


    /**
     * Effectue la validation et retourne le résultat
     * @return bool
     */
    public function success() {
        $this->test();
        return $this->hasSucceeded;
    }

    /**
     * Retourne la valeur vérifiée, passé dans la fonction ctrlSaisies()
     * Nécessite que le validator ait été validé via sa fonction success()
     */
    public function verifiedField($fieldName, $ctrlSaisie=true) {
        try {
            if(!$this->hasSucceeded) {
                throw new Error('Le validator n\'a pas été validée');
            }
            return $ctrlSaisie?ctrlSaisies($this->fieldsValues[$fieldName]) : $this->fieldsValues[$fieldName];
        } catch(Error $e) {
			die('Erreur validator : ' . $e->getMessage());
        }
    }


    /**
     * Retourne le fichier vérifié
     * Nécessite que le validator ait été validé via sa fonction success()
     */
    public function verifiedFile($fieldName) {
        try {
            if(!$this->hasSucceeded) {
                throw new Error('Le validator n\'a pas été validée');
            }
            return $this->fieldsValues[$fieldName];
        } catch(Error $e) {
			die('Erreur validator : ' . $e->getMessage());
        }
    }

    /**
     * Retourne si le champ ou le fichier est rempli
     * Nécessite que le validator ait été validé via sa fonction success()
     */
    public function isFilled($fieldName) {
        try {
            if(!$this->hasSucceeded) {
                throw new Error('Le validator n\'a pas été validée');
            }
            return (isset($this->fieldsFilled[$fieldName]) AND $this->fieldsFilled[$fieldName]===true);
        } catch(Error $e) {
			die('Erreur validator : ' . $e->getMessage());
        }
    }


    public function oldField($fieldName, $fieldValueFromBDD=false) {
        if(isset($this->fieldsValues[$fieldName])) return $this->fieldsValues[$fieldName];
        if($fieldValueFromBDD) return $fieldValueFromBDD;
        return '';
    }

    // marche pas
    public function oldFile($fieldName, $fieldValueFromBDD=false) {
        if(isset($this->fieldsValues[$fieldName])) return $this->fieldsValues[$fieldName]['tmp_name'];
        if($fieldValueFromBDD) return $fieldValueFromBDD;
        return '';
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

    public function echoErrors() {
        if(count($this->errorsArray)==0) return;
        echo '<div class="errors">';
        foreach($this->errorsArray as $error) {
            echo '<div class="error">'.$error.'</div>';
        }
        echo '</div>';
    }

    private function addErrors($errors) {
        foreach($errors as $error) {
            array_push($this->errorsArray, $error);
        }
    }
} 