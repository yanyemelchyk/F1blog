<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\User;
use App\Helpers\Validator;

class RegisterController extends Controller
{
    protected function setMiddleware()
    {
        // TODO: Implement setMiddleware() method.
    }

    /*
     * todo
     * in future we should do something similar
     * RegisterController
     *      loginAction
     *      logoutAction
     * Article
     *      indexAction
     *      showAction
     *      createAction
     *      deleteAction
     * and so on for all other controllers
     *
     * it is CRUD implementation
     */
    public function indexAction()
    {
        $this->view->template = 'register.php';
        $this->view->title = 'Регистрация пользователя';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = new Validator();
            //todo replace clean - use more strict validateion (digits, alpha)
            $username = $validator->clean($_POST['username']);
            $password1 = $validator->clean($_POST['password1']);
            $password2 = $validator->clean($_POST['password2']);
            $validator->checkEmpty($username, 'Введите имя пользователя');
            $validator->checkEmpty($password1, 'Введите пароль');
            $validator->checkEmpty($password2, 'Введите подтверждение пароля');
            $validator->confirmPassword($password1, $password2, 'Пароль и подтверждение не совпадают');

            if ($validator->getError()) {
                $this->displayMessage($validator->getError());
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
            $this->view->template = 'login.php';
            $this->view->title = 'Авторизация пользователя';
            $this->view->errorMsg[] = 'Ваш аккаунт создан. Вы можете войти';
        }
        //todo try to avoid else statement where it is possible
        $this->view->render();
    }
}
