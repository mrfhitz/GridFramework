<?php

/**
 * Class Model
 */
abstract class Model {
    /* @var string */
    private $name;

    /**
     * @param $name of the model.
     */
    public function __construct($name){
        $this->name = $name;
    }

    /**
     * @return name of the model
     */
    public function getModelName(){
        return $this->name;
    }
}