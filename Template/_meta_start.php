<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="<?=Config::get('meta_info/description');?>"/>
    <meta name="keywords" content="<?=Config::get('meta_info/keywords') ;?>" />
    <meta name="author" content="<?=Config::get('meta_info/author');?>" />
    <meta name="template" content="<?=Config::get('meta_info/template');?>" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link href="lib/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?=Config::get('view/root_path');?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?=Config::get('view/root_path');?>/css/<?=strtolower(Config::get('view/page_name'))?>.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="favicon.ico">
    <title><?=Config::get('meta_info/title');?></title>
    <?php foreach(Plugins::loadPluginsCSSFiles() as $value) echo $value; ?>
    <meta name="plugins" content="<?php $plugins = ""; foreach(Plugins::loadPluginsPath() as $value) $plugins .= $value . ','; echo(str_replace(Config::get('folders/plugins')."/", "",rtrim($plugins, ",")));  ?>"/>
</head>
<body>