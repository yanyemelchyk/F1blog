<?php

namespace App\Core;

use App\Views\View;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    protected function middleware($absName)
    {
        $absName::handle();
    }

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

    protected function sessionInit()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            if (isset($_COOKIE['userId']) && isset($_COOKIE['username'])) {
                $_SESSION['userId'] = $_COOKIE['userId'];
                $_SESSION['username'] = $_COOKIE['username'];
            }
        }
    }
}