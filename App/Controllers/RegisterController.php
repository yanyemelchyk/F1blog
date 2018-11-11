<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\User;
use App\Helpers\Validator;

class RegisterController extends Controller
{
    public function indexAction()
    {
        $this->setViewValues('register.php', 'Регистрация пользователя');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = new Validator();
            $username = $validator->cleanAndCheckEmpty($_POST['username'], 'Введите имя пользователя');
            $password1 = $validator->cleanAndCheckEmpty($_POST['password1'], 'Введите пароль');
            $password2 = $validator->cleanAndCheckEmpty($_POST['password2'], 'Введите подтверждение пароля');
            $validator->confirmPassword($password1, $password2, 'Пароль и подтверждение не совпадают');

            if (!$validator->isErrorEmpty()) {
                $this->displayMessage($validator->getHtmlMessage());
                return;
            }
            if (User::findByName($username)) {
                $this->displayMessage('Пользователь с таким логином уже существует');
                return;
            }
            $password = password_hash($password1, PASSWORD_DEFAULT);

            if (!User::create($username, $password)) {
                $this->displayMessage('Произошла ошибка при создании пользователя. Повторите попытку');
                return;
            }

            $this->setViewValues('login.php', 'Авторизация пользователя');
            $this->displayMessage('Ваш аккаунт создан. Вы можете войти');
        } else {
            $this->view->render();
        }
    }
}