<?php
class Validate {
    private $_passed = false,
        $_errors = array(),
        $_db = null;
    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()){
        foreach($items as $item => $rules){
            foreach($rules as $rule => $rules_value){
                $value = trim($source[$item]);
                $item = escape($item);

                if($rule === 'required' && empty($value)){
                    $this->addError("{$rules['name']} is required!");

                } else if($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addError("{$rules['name']} is not valid!");

                } else if(!empty($value)){
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rules_value) {
                                $this->addError("{$rules['name']} must be a minimum of {$rules_value} characters.");
                            }
                            break;
                        case 'max':
                            if(strlen($value) > $rules_value) {
                                $this->addError("{$rules['name']} must be a maximum of {$rules_value} characters.");
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rules_value]){
                                $this->addError("{$rules['name']} must match.");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rules_value, array($item, '=', $value));
                            if($check->count()){
                                $this->addError("{$rules['name']} alredy exists.");
                            }
                            break;
                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }
}