<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

$GLOBALS['config'] = parse_ini_file("config.ini", true);

spl_autoload_register(function($class){
    require_once $GLOBALS['config']['folders']['framework_files'] . '/' . $class . '.php';
});

Debug::enableDebug();

Plugins::loadPluginsPHPFiles();
Plugins::preLoadFile();