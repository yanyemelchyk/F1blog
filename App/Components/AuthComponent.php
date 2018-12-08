<?php
namespace App\Components;

use App\Core\App;
use App\Entities\Session;
use App\Entities\User;
use App\Repositories\SessionRepository;

class AuthComponent
{
    public $errors;

    public function authAction($username, $password)
    {
        if (!ctype_alnum($username)) {
            $this->errors[] = 'Введите ваше имя пользователя';
        }
        if (!ctype_alnum($password)) {
            $this->errors[] = 'Введите ваш пароль';
        }
        if (!$this->errors) {
            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user->getPassword())) {
                $this->sessionAction($user);
                App::getInstance()->router->redirect('/');
            } else {
                $this->errors[] = 'Неправильный логин или пароль';
            }
        }
        return $this->errors;
    }

    public function sessionAction($user)
    {
        $_SESSION['user'] = $user;
        $date = new \DateTime('+5 days');
        $expires = $date->format('U');
        $session = new Session();
        $session->setExpires($expires);
        $session->setId(session_id());
        $session->setUserId($user->getId());
        SessionRepository::create($session);
        setcookie("sessionId", session_id(), $expires, "/");
    }
}
