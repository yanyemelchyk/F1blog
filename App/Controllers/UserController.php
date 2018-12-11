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
                echo json_encode(array('message' => 'Допустимы только латинские буквы и цифры'));
                return;
            }
            if ($password !== $password2) {
                echo json_encode(array('message' => 'Пароль и подтверждение не совпадают'));
                return;
            }
            if (User::findByUsername($username)) {
                echo json_encode(array('message' => 'Пользователь с таким логином уже существует'));
                return;
            }
            $password = password_hash($password, PASSWORD_DEFAULT);

            if (!User::create($username, $password)) {
                echo json_encode(array('message' => 'Произошла ошибка при создании пользователя. Повторите попытку'));
                return;
            }
            echo json_encode(array('success' => 'true', 'message' => 'Ваш аккаунт создан. Вы можете войти'));
            return;
        }
        $this->view->render('register.php', ['title' => 'Регистрация пользователя', 'userAuthorized' => false]);
    }

    public function showAction()
    {
        $user = User::findByUserId($_SESSION['user']->getId());
        if (!$user) {
            $this->view->errors[] = 'При загрузке данных профиля произошла ошибка. Повторите попытку';
        }
        $this->view->render(
            'profile.php',
            [
                'title' => 'Профиль пользователя',
                'user' => $user,
                'userAuthorized' => true
            ]
        );
    }
}
