<?php

namespace App\Core;

use App\Exceptions\NotFoundHttpException;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $routesMap = Map::getRoutes();
        foreach ($routesMap as $value) {
            $route = $this->add(array_shift($value));
            $this->routes[$route] = $value;
        }
    }

    public function add($route)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        return $route;
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url,$matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key) && is_numeric($match)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if (!$this->match()) {
            throw new NotFoundHttpException('Router!');
        }
        $path = '\App\Controllers\\' . ucfirst($this->params['controller']) . 'Controller';

        if (!class_exists($path)) {
            throw new NotFoundHttpException('Controller!');
        }
        $action = $this->params['action'] . 'Action';
        $controller = new $path;
        $controller->run($action);
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getUrl($alias, $params = null)
    {
        $url = '/';
        $routesMap = Map::getRoutes();
        foreach ($routesMap as $key => $value) {
            if ($key === $alias) {
                $url .= preg_replace('/{([a-z]+):([^\}]+)}/', '', $value['url']);
            }
        }
        if (!is_null($params)) {
            foreach ($params as $param) {
                $url .= $param;
            }
        }
        return $url;
    }
}
