<?php
namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Session;
use App\Entities\User;
use App\Helpers\Validator;
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

        if (!isset($_SESSION['userId']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();
            $username = $validator->clean($_POST['username']);
            $password = $validator->clean($_POST['password']);
            $validator->checkEmpty($username, 'Введите ваше имя пользователя');
            $validator->checkEmpty($password, 'Введите ваш пароль');

            if ($validator->getError()) {
                $this->displayMessage($validator->getError());
                return;
            }
            $user = User::login($username, $password);

            if (!$user || !password_verify($password, $user->getPassword())) {
                $this->displayMessage('Неправильный логин или пароль');
                return;
            }


            $_SESSION['user'] = $user;


            $date = new DateTime('+5 days');
            $expires = $date->format('U');
            $session = new Session();
            $session->setExpires($expires);
            $session->setSessionId(session_id());
            $session->setUserId($user->getUserId());
            SessionRepository::createSession($session);
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

        if (isset($_SESSION['userId'])) {
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
