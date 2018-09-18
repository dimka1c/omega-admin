<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 006 06.09.18
 * Time: 11:26
 */

namespace vendor\core;


class AppView
{
    public $route = [];

    public $layout;

    public $view;

    public $scriptsTemplate = [];

    public $scriptsLayouts = [];

    public $scriptStyleSheet = [];

    protected $token;

    public function __construct($route, $view = '', $layout = '')
    {
        $this->route = $route;
        if ($layout !== false) {
            $this->layout = $layout ?: LAYOUT;
        } else {
            $this->layout = $layout;
        }
        $this->view = $view;
    }

    private function upper($name)
    {
        return mb_strtolower($name);
    }

    public function render($vars)
    {
        $this->csrfToken();
        if(is_array($vars)) {
            extract($vars);
        }
        $fileView = APP . "/app/views/{$this->upper($this->route['controller'])}/{$this->upper($this->view)}.php";
        ob_start();
        if(is_file($fileView)) {
            require $fileView;
        } else {
            echo "Не найден файл вида <b>{$fileView}</b>";
        }
        $content = $this->getScriptTemplate(ob_get_clean());
        $content = $this->getStyleTemplate($content);
        if ($this->layout) {
            $fileLayout = APP . "/app/views/layout/{$this->layout}.php";
            if (is_file($fileLayout)) {
                require $fileLayout;
            } else {
                echo "Не найден layout <b>{$fileLayout}</b>";
            }
        }
    }

    protected function getScriptTemplate(string $content): string
    {
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $matches);
        if (is_array($matches)) {
            $this->scriptsTemplate = $matches;
            return preg_replace($pattern, '', $content);
        }
        return $content;
    }

    protected function getStyleTemplate(string $content): string
    {
        $pattern = "#<link rel=.*?>#si";
        preg_match_all($pattern, $content, $matches);
        if (is_array($matches)) {
            $this->scriptStyleSheet = $matches;
            return preg_replace($pattern, '', $content);
        }
        return $content;
    }

    protected function csrfToken()
    {
        $this->token = bin2hex(random_bytes(32));
        $_SESSION['_csrf_token'] = $this->token;

    }

    public function issetFlash(string $nameFlash): bool
    {
        return (isset($_SESSION['flash'][$nameFlash]));
    }

    public function getFlash(string $nameFlash): string
    {
        $msg = $_SESSION['flash'][$nameFlash];
        unset ($_SESSION['flash'][$nameFlash]);
        return $msg;
    }

}