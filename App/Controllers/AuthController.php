<?php
namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\User;
use App\Helpers\Validator;
use DateTime;

class AuthController extends Controller
{
    public function loginAction()
    {
        $app = App::getInstance();
        $this->setViewValues('login.php', 'Авторизация пользователя');

        if (!isset($_SESSION['userId']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();

            $username = $validator->cleanAndCheckEmpty($_POST['username'], 'Введите ваше имя пользователя');
            $password = $validator->cleanAndCheckEmpty($_POST['password'], 'Введите ваш пароль');

            if (!$validator->isErrorEmpty()) {
                $this->displayMessage($validator->getHtmlMessage());
                return;
            }
            $user = User::login($username, $password);

            if (!$user) {
                $this->displayMessage('Пользователя с таким логином не существует');
                return;
            }
            if (!password_verify($password, $user->getPassword())) {
                $this->displayMessage('Неверный пароль');
                return;
            }
            $_SESSION['userId'] = $user->getUserId();
            $_SESSION['username'] = $user->getUsername();
            $date = new DateTime('+30 days');
            setcookie("userId", $user->getUserId(), $date->format('U'), "/");
            setcookie("username", $user->getUsername(), $date->format('U'), "/");

            $app->router->redirect('/');
        } else {
            $this->view->render();
        }
    }

    public function logoutAction()
    {
        $app = App::getInstance();

        session_start();
        if (isset($_SESSION['userId'])) {
            $_SESSION = array();
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }
            session_destroy();
        }
        setcookie("userId", "", time() - 3600, "/");
        setcookie("username", "", time() - 3600, "/");

        $app->router->redirect('/');
    }
}