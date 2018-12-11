<?php
namespace App\Components;

use App\Entities\Session;
use App\Entities\User;
use App\Repositories\SessionRepository;

class AuthComponent
{
    public $error;

    public function signIn($username, $password)
    {
        if (!ctype_alnum($username)) {
            $this->error = 'Введите ваше имя пользователя';
            return false;
        }
        if (!ctype_alnum($password)) {
            $this->error = 'Введите ваш пароль';
            return false;
        }
        $user = User::findByUsername($username);

        if (!$user || !password_verify($password, $user->getPassword())) {
            $this->error = 'Неправильный логин или пароль';
            return false;
        }
        $this->sessionStart($user);
        return true;
    }

    public function getError()
    {
        return $this->error;
    }

    private function sessionStart($user)
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
