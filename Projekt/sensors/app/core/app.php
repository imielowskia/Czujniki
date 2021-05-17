<?php

class App
{
    // default
    private $controller = 'homepage';
    private $method = 'index';
    private $params = [];

    // calls adequate controllers method based on current url,
    // for example, .../controller/method/params/ calls controller.method(params)
    public function __construct()
    {
        $CONTROLLER_PATH = '../app/controllers/';

        // turn arguments from url after /public/ into array, where 
        // [0] - controllers name
        // [1] - method name
        // [2..n] - arguments
        $url = $this->parseUrl();

        if (isset($url[0])) {
            if (file_exists($CONTROLLER_PATH . $url[0] . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }

        require_once($CONTROLLER_PATH . $this->controller . '.php');

        // create a new object identified by its name 
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // save the rest of parameters into params
        $this->params = $url ? array_values($url) : [];


        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}
