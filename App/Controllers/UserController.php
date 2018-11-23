<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\User;
use App\Middleware\AuthMiddleware;
use App\Middleware\CheckSessionMiddleware;

class UserController extends Controller
{
    protected function setMiddleware()
    {
        $this->middleware = [
            'showAction' => [
                new CheckSessionMiddleware(),
                new AuthMiddleware()
            ],
        ];
    }

    public function createAction()
    {
        $this->view->template = 'register.php';
        $this->view->title = 'Регистрация пользователя';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password1'];
            $password2 = $_POST['password2'];

            if (!ctype_alnum($username) || !ctype_alnum($password)) {
                $this->view->errorMsg[] = 'Допустимы только латинские буквы и цифры';
            }
            if ($password !== $password2) {
                $this->view->errorMsg[] = 'Пароль и подтверждение не совпадают';
            }
            if ($this->view->errorMsg) {
                $this->view->render();
                return;
            }
            if (User::findByUsername($username)) {
                $this->view->errorMsg[] = 'Пользователь с таким логином уже существует';
                $this->view->render();
                return;
            }
            $password = password_hash($password, PASSWORD_DEFAULT);

            if (!User::create($username, $password)) {
                $this->view->errorMsg[] = 'Произошла ошибка при создании пользователя. Повторите попытку';
                $this->view->render();
                return;
            }
            $this->view->template = 'login.php';
            $this->view->title = 'Авторизация пользователя';
            $this->view->errorMsg[] = 'Ваш аккаунт создан. Вы можете войти';
            $this->view->render();
        } else {
            $this->view->render();
        }
    }

    public function showAction()
    {
        $this->view->template = 'profile.php';
        $this->view->title = 'Профиль пользователя';

        $user = User::findByUserId($_SESSION['user']->getId());
        if (!$user) {
            $this->view->errorMsg[] = 'При загрузке данных профиля произошла ошибка. Повторите попытку';
            $this->view->render();
            return;
        }
        $this->view->user = $user;
        $this->view->render();
    }
}
