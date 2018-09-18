<?php

namespace vendor\core;

Class Router {

    /*
     * таблица маршрутов
     * @var array
     */
    protected static $routes  = [];

    /*
     * текущий маршрут
     * @var array
     */
    protected static $route = [];

    /*
     * добавляет маршрут в таблицу маршрутов
     *
     * @param string $regexp решулярное выражение маршрута
     * @param array $route маршрут [controller, action, params]
     */
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRouters()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    /*
     * перенапрявляет url по нашему адресу
     * @var string $url входящий URL
     * @return void
     */
    public static function matches($url)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $key => $val) {
                    if(is_string($key)) {
                        $route[$key] = $val;
                    }
                }
                if(!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /*
     * переводит
     */
    protected static function upperCamelCase($className) {
        $nameCamelCase = '';
        $name = explode('-', $className);
        foreach ($name as $item) {
            $nameCamelCase .= ucwords($item);
        }
        return $nameCamelCase;
    }

    public static function dispatch($url)
    {

        if (self::matches($url)) {
            $controller = 'app\controllers\\' . self::upperCamelCase(self::$route['controller'] . 'Controller');
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = 'action' . self::upperCamelCase(self::$route['action']);
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                    $controllerObject->getView();
                } else {
                    echo 'Метод <b>' . $action . '</b> в контроллере ' . $controller . ' не найден';
                }
            } else {
                echo 'контроллер <b>' . $controller . '</b> не найден';
            }
        }
    }
}

