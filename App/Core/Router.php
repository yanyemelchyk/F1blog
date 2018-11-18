<?php
namespace App\Core;

use App\Exceptions\NotFoundHttpException;

class Router
{
    const DEFAULT_CONTROLLER = 'IndexController';
    const DEFAULT_ACTION = 'indexAction';

    private $controller;
    private $action;
    private $params;

    public function __construct()
    {
        $request = $_SERVER['REQUEST_URI'];
        $segments = explode('/', trim($request, '/'));
        $this->controller = $segments[0] ? ucfirst($segments[0]) . 'Controller' : self::DEFAULT_CONTROLLER;
        $this->action = isset($segments[1]) ? $segments[1] . 'Action' : self::DEFAULT_ACTION;
        if (isset($segments[2])) {
            $cnt = count($segments);
            for ($i = 2; $i < $cnt; $i += 2) {
                $this->params[$segments[$i]] = $segments[$i+1];
            }
        }
    }

    public function run()
    {
        $controllerName = '\App\Controllers\\' . $this->getController();

        if (!class_exists($controllerName)) {
            throw new NotFoundHttpException('Controller!');
        }
        /** @var $controller Controller */
        $controller = new $controllerName;
        $controller->run($this->getAction());
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
    }

    public function refresh()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }
}
