<?php

namespace vendor\core;

abstract class AppController
{
    public $route = [];

    public $view;

    public $layout;

    public $vars = [];

    public function __construct($route)
    {
        session_start();
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView()
    {
        $viewObject = new AppView($this->route, $this->view, $this->layout);
        $viewObject->render($this->vars);
    }

    public function setDataView($vars)
    {
        $this->vars = $vars;
    }

    public function isAjax(): bool
    {
        $ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
        if (isset($_POST['token']) && $this->csrfIsOk($_POST['token'])){
            return $ajax;
        }
        return false;
    }

    public function csrfIsOk(string $token): bool
    {
        if (isset($_SESSION['_csrf_token'])) {
            if ($_SESSION['_csrf_token'] === $token) return true;
        }
        return false;
    }

    public function setFlash(string $nameFlash, string $msg): void
    {
        $_SESSION['flash'][$nameFlash] = $msg;
    }
}