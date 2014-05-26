<?php

/**
 * Class Controller
 */
abstract class Controller {
    /* @var Model */
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }
}