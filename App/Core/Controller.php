<?php

namespace App\Core;

use App\Exceptions\NotFoundHttpException;
use App\Middleware\MiddlewareInterface;
use App\Views\View;

abstract class Controller
{
    protected $view;

    /**
     * @var MiddlewareInterface[]
     */
    protected $middleware = [];

    public function __construct()
    {
        session_start();
        $this->view = new View();
    }

    public function run($action)
    {
        if (!method_exists($this, $action)) {
            throw new NotFoundHttpException('action not fount');
        }
        if (isset($this->middleware[$action])) {
            foreach ($this->middleware as $middleware) {
                $middleware->handle();
            }
        }
        $this->$action();
    }

    //todo no. do it explicit in each controller --- next iteration, not now
    protected function setViewValues($template, $title)
    {
        $this->view->template = $template;
        $this->view->title = $title;
    }

    protected function displayMessage($message)
    {
        $this->view->errorMsg = $message;
        $this->view->render();
    }

    //todo can be dropped
    protected function sessionInit()
    {
        session_start();
        //todo wtf ? if there is no user in session we check cookie ? what if i will set userId and username manually in browser ?
        //create AuthComponent which will have method getUser
        if (!isset($_SESSION['userId'])) {
            if (isset($_COOKIE['userId']) && isset($_COOKIE['username'])) {
                $_SESSION['userId'] = $_COOKIE['userId'];
                $_SESSION['username'] = $_COOKIE['username'];
            }
        }
    }

    abstract protected function setMiddleware();
}
