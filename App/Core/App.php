<?php
namespace App\Core;

class App
{
    public $router;

    private static $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function route()
    {
        $this->router = new Router();
        $this->router->run();
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }
}