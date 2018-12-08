<?php
namespace App\Controllers;

use App\Components\AuthComponent;
use App\Core\App;
use App\Core\Controller;
use DateTime;

class AuthController extends Controller
{
    protected function setMiddleware()
    {
        // TODO: Implement setMiddleware() method.
    }

    public function loginAction()
    {
        if (!isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $authComp = new AuthComponent();
            $this->view->errors = $authComp->authAction($_POST['username'], $_POST['password']);
        }
        $this->view->render('login.php', ['title' => 'Авторизация пользователя']);
    }

    public function logoutAction()
    {
        $date = new DateTime('-5 days');
        $expires = $date->format('U');

        if (isset($_SESSION['user'])) {
            $_SESSION = array();

            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', $expires, '/');
            }
            session_destroy();
        }
        setcookie("sessionId", "", $expires, "/");

        App::getInstance()->router->redirect('/');
    }
}
