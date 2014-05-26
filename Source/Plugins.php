<?php
class Plugins {

    public static function loadPluginsPHPFiles(){
        foreach(self::loadPluginsPath() as $plugin_path){
            foreach(self::allFiles($plugin_path, "php") as $file_path){
                if(file_exists($file_path)){
                    require_once $file_path;
                }
            }
        }
    }

    public static function loadPluginsJSFiles(){
        $arr = array();
        foreach(self::loadPluginsPath() as $plugin_path){
            foreach(self::allFiles($plugin_path, "js") as $file_path){
                if(file_exists($file_path)){
                    $arr[] = '<script src="' . $file_path . '"></script>';
                }
            }
        }
        return $arr;
    }

    public static function loadPluginsCSSFiles(){
        $arr = array();
        foreach(self::loadPluginsPath() as $plugin_path){
            foreach(self::allFiles($plugin_path, "css") as $file_path){
                if(file_exists($file_path)){
                    $arr[] = '<link href="' . $file_path . '" rel="stylesheet" type="text/css">';
                }
            }
        }
        return $arr;
    }

    public static function preLoadFile(){
        foreach(self::loadPluginsPath() as $plugin_path){
            $file = $plugin_path . '/preload.php';
            if(file_exists($file)) {
                require_once $file;
            }
        }
    }

    public static function loadPluginsPath(){
        $arr = array();
        $plugins = self::allFolders(Config::get('folders/plugins'));

        foreach($plugins as $plug_path){
            $arr[] = $plug_path;
        }
        return $arr;
    }

    private static function allFiles($path, $extension = "php"){
        $arr = array();
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                $ext = $ext = pathinfo($entry, PATHINFO_EXTENSION);
                if ($entry != "." && $entry != ".." && !empty($ext) && strtolower($ext) == $extension) {
                    $arr[] = $path . '/' . $entry;
                }
            }
            closedir($handle);
        }
        return $arr;
    }

    private static function allFolders($path){
        $arr = array();
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                $ext = pathinfo($entry, PATHINFO_EXTENSION);
                if ($entry != "." && $entry != ".." && empty($ext)) {
                    $arr[] = $path . '/' . $entry;
                }
            }
            closedir($handle);
        }
        return $arr;
    }

}