<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];
    protected $subFolder = '';
    private $controllersBase;

    public function __construct() {
        $this->controllersBase = __DIR__ . '/../controllers/';
        $url = $this->parseURL();

        if (isset($url[0]) && is_dir($this->controllersBase . $url[0])) {
            $this->subFolder = $url[0] . '/';
            $folderName = $url[0];
            unset($url[0]);

            $this->controller = ucwords($folderName) . 'Controller';

            if (isset($url[1])) {
                $controllerName = ucwords($url[1]) . 'Controller';
                if (file_exists($this->controllersBase . $folderName . '/' . $controllerName . '.php')) {
                    $this->controller = $controllerName;
                    unset($url[1]);
                }
            }
        } elseif (isset($url[0])) {
            $controllerName = ucwords($url[0]) . 'Controller';
            if (file_exists($this->controllersBase . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        $path = $this->controllersBase . $this->subFolder . $this->controller . '.php';

        if (file_exists($path)) {
            require_once $path;
        } else {
            require_once $this->controllersBase . 'HomeController.php';
            $this->controller = 'HomeController';
        }

        if (!class_exists($this->controller)) {
            die("Error: File ditemukan di $path, tapi class <b>{$this->controller}</b> tidak ada di dalam file tersebut!");
        }

        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if (!empty($url)) {
            $this->params = array_values($url);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}