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

    public function indexAction()
    {
        $this->view->render('login.php', ['title' => 'Авторизация пользователя', 'userAuthorized' => false]);
    }

    public function loginAction()
    {
        if (!isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new AuthComponent();
            if ($auth->signIn($_POST['username'], $_POST['password'])) {
                echo json_encode(array('redirect' => '/'));
                return;
            }
            echo json_encode(array('message' => $auth->getError()));
        }
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
