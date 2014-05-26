<?php
class Bootstrap {

    public function __construct() {
        $this->includeRequirements();
        $pageName= $this->getPage();
        $this->loadPage($pageName);
    }

    private function includeRequirements(){
        // Prepare our Seccions / Coockies / MVC system
        require_once '_init.php';
    }

    private function getPage(){
        // Page Manager - read page
        $URL = Page::getPage();

        // Find if page as been selected
        if($URL === false){
            $URL = 'home';
        }else{

            if(Page::getSubPage() !== false){
                $URL .= '_' . Page::getSubPage();
            }
        }
        return $URL;
    }

    private function loadPage($URL){
        // try to load the page
        try{
            $URL_MODEL = $URL . '_model';
            $URL_VIEW = $URL . '_view';
            $URL_CONTROLLER = $URL . '_controller';

            if (! @include_once(Config::get('folders/models') . '/' . $URL_MODEL . '.php'))
                throw new Exception ('file does not exist');

            if (! @include_once(Config::get('folders/views') . '/' . $URL_VIEW . '.php'))
                throw new Exception ('file does not exist');

            if (! @include_once(Config::get('folders/controllers') . '/' . $URL_CONTROLLER . '.php'))
                throw new Exception ('file does not exist');

            $model = new $URL_MODEL();
            $controller = new $URL_CONTROLLER($model);
            $view = new $URL_VIEW($controller, $model);

            if (isset($_GET['action']) && !empty($_GET['action'])) {
                $controller->{$_GET['action']}();
            }

            echo $view->output();

        }catch(Exception $e){
           die($e->getMessage());
           //Redirect::to(Page::composeURL('error'));
        }
    }
}