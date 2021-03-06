<?php

namespace App\Core;

use App\Exceptions\NotFoundHttpException;
use App\Views\View;
use App\Middleware\MiddlewareInterface;

abstract class Controller
{
    protected $view;

    /**
     * @var MiddlewareInterface[]
     */
    protected $middleware;

    public function __construct()
    {
        session_start();
        $this->view = new View();
    }

    public function run($action)
    {
        if (!method_exists($this, $action)) {
            throw new NotFoundHttpException('action not found');
        }
        $this->setMiddleware();

        if (isset($this->middleware[$action])) {
            foreach ($this->middleware[$action] as $middleware) {
                $middleware->handle();
            }
        }
        $this->$action();
    }

    abstract protected function setMiddleware();
}
