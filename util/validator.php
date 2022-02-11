<?php

class ValidationRule {
    public $validator;

    public $field;
    public $isRequired;

    static public function make($field) {
        return new static($field);
    }

    static public function required($field) {
        return static::make($field)->setIsRequired(true);
    }

    static public function optionnal($field) {
        return static::make($field)->setIsRequired(false);
    }
    

    function __construct($field) {
        $this->field = $field;
        $this->isRequired = false;

        return $this;
    }

    public function isValid() {
        if($this->isRequired) {
            if(
                !isset($this->setValidator->$fieldsValues[$this->field])
                OR empty($this->setValidator->$fieldsValues[$this->field])
            ) return false;
        }

        return true;
    }

    public function setValidator($validator) {
        $this->validator = $validator;
    }

    public function setIsRequired($isRequired) {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function isSameFieldName($ruleToCompare) {
        return $this->field === $ruleToCompare->field;
    }
}

class Validator {
    public $rules = [];
    public $fieldsValues = [];

    public $tested = false;
    public $hasSucceeded = null;


    static public function make($rules) {
        return new static($rules);
    }

    function __construct($rules) {
        foreach($rules as $newRule) {
            $this->addRule($newRule);
        }
    }

    public function bindValues($fields) {
        $this->fieldsValues = $fields;
        return $this;
    }

    public function success() {
        $this->tested = true;

        $this->hasSucceeded = true;
        foreach($this->rules as $rule) {
            if( !$rule->isValid() ) {
                $this->hasSucceeded = false;
                break;
            }
        }

        return $this->hasSucceeded;
    }

    public function ruleExist($ruleToCompare) {
        $searchResultCount = array_filter(
            $this->rules, 
            fn($rule)=>$rule->isSameField($ruleToCompare)
        );
        // s'il y a au moins un résultat, la règle existe
        $exists = $searchResultCount > 0;
        return $exists;
    }

    public function addRule($potentialRule) {

        // vérifie que c'est bien une rule
        if($potentialRule instanceof ValidationRule) {
            
            // l'ajoute si elle n'existe pas déjà
            if( !$this->ruleExist($potentialRule) ) {
                array_push(
                    $this->rules, 
                    $potentialRule
                );
            } 
        }
        return $this;        
    }
} 