<?php

/**
 * Class Config
 */
class Config{
    /**
     * @param $path for some config
     * @return false if is empty or result if can found your settings
     */
    public static function get($path = null){
        if($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach($path as $bit){
                if(isset($config[$bit])){
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
}