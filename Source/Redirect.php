<?php

/**
 * Class Redirect
 */
class Redirect {

    /**
     * Redirect people to one location using header files
     * @param URL destination
     */
    public static function to($location = null){
        if($location){
            header('Location: ' . $location);
            exit();
        }
    }

}