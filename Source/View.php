<?php

/**
 * Class View
 */
abstract class View{
    /* @var Model*/
    protected $model;
    /* @var Controller */
    protected $controller;
    /* @var Array */
    protected $meta_start, $meta_end;
    /* @var Array */
    protected $template;


    /**
     * @param $controller
     * @param $model
     * @param array $meta_start
     * @param array $meta_end
     */
    public function __construct($controller, $model) {
        $this->controller = $controller;
        $this->model = $model;
        $this->template = Config::get('meta_info/template');
        $this->initAllVars();
    }

    public function initAllVars(){
        $GLOBALS['config']['view'] = array(
            'page_name' => $this->model->getModelName(),
            'page_template' => $this->template,
            'root_path' => Config::get('folders/templates') . '/' . $this->template
        );
    }

    /**
     * @return string name of the template
     */
    public function getTemplateName(){
        return $this->template;
    }

    /**
     * @ Output html page
     */
    public function output() {
        require_once Config::get('folders/templates') . '/_meta_start.php';
        require_once Config::get('folders/templates') . '/' . $this->template . '/_meta_start.php';
        require_once Config::get('folders/templates') . '/'. $this->template .'/' . strtolower($this->model->getModelName()) . '.php';
        require_once Config::get('folders/templates') . '/' . $this->template . '/_meta_end.php';
        require_once Config::get('folders/templates') . '/_meta_end.php';
    }
}