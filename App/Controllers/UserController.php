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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password1'];
            $password2 = $_POST['password2'];

            if (!ctype_alnum($username) || !ctype_alnum($password)) {
                $this->view->errors[] = 'Допустимы только латинские буквы и цифры';
            }
            if ($password !== $password2) {
                $this->view->errors[] = 'Пароль и подтверждение не совпадают';
            }
            if (!$this->view->errors) {

                if (!User::findByUsername($username)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    if (User::create($username, $password)) {
                        $this->view->message = 'Ваш аккаунт создан. Вы можете войти';
                        $this->view->render('login.php', ['title' => 'Авторизация пользователя']);
                        return;
                    } else {
                        $this->view->errors[] = 'Произошла ошибка при создании пользователя. Повторите попытку';
                    }
                } else {
                    $this->view->errors[] = 'Пользователь с таким логином уже существует';
                }
            }
        }
        $this->view->render('register.php', ['title' => 'Регистрация пользователя']);
    }

    public function showAction()
    {
        $user = User::findByUserId($_SESSION['user']->getId());
        if (!$user) {
            $this->view->errors[] = 'При загрузке данных профиля произошла ошибка. Повторите попытку';
        }
        $this->view->render('profile.php', ['title' => 'Профиль пользователя', 'user' => $user]);
    }
}
