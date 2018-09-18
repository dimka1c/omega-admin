<?php

error_reporting(E_ALL);

use vendor\core\Router;

define('APP', dirname(__DIR__));
define('LAYOUT', 'default');

//require APP . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $file = APP . '/' . str_replace('\\', '/', $class) . '.php';
    require $file;
});

$query = rtrim($_SERVER['QUERY_STRING'], '/');

Router::add('^$', ['controller' => 'Main', 'action' => 'Index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);