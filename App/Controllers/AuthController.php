<?php
namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Session;
use App\Entities\User;
use App\Repositories\SessionRepository;
use DateTime;

class AuthController extends Controller
{
    protected function setMiddleware()
    {
        // TODO: Implement setMiddleware() method.
    }

    public function loginAction()
    {
        $this->view->template = 'login.php';
        $this->view->title = 'Авторизация пользователя';

        if (!isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (!ctype_alnum($username)) {
                $this->view->errorMsg[] = 'Введите ваше имя пользователя';
            }
            if (!ctype_alnum($password)) {
                $this->view->errorMsg[] = 'Введите ваш пароль';
            }
            if ($this->view->errorMsg) {
                $this->view->render();
                return;
            }
            $user = User::findByUsername($username);

            if (!$user || !password_verify($password, $user->getPassword())) {
                $this->view->errorMsg[] = 'Неправильный логин или пароль';
                $this->view->render();
                return;
            }
            $_SESSION['user'] = $user;
            $date = new DateTime('+5 days');
            $expires = $date->format('U');
            $session = new Session();
            $session->setExpires($expires);
            $session->setId(session_id());
            $session->setUserId($user->getId());
            SessionRepository::create($session);
            setcookie("sessionId", session_id(), $expires, "/");

            App::getInstance()->router->redirect('/');
        } else {
            $this->view->render();
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
