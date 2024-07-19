<?php

namespace App\Http\Middleware\HomeControllers;

use AltoRouter as Router;

class Routing
{
    private $router;

    public function __construct($basePath)
    {
        require 'lib/autoload.php';
        $this->router = new Router();
        $this->router->setBasePath($basePath);
    }

    public function get($route, $action)
    {
        $this->router->map("GET", $route, $action);
    }

    public function post($route, $action)
    {
        $this->router->map("POST", $route, $action);
    }

    public function request($route, $action)
    {
        $this->router->map("GET|POST", $route, $action);
    }

    public function matchCurrentRequest()
    {
        $match = $this->router->match();
        if ($match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            require "views/error404.php";
        }
    }

    public function run()
    {
        $this->matchCurrentRequest();
    }
}
