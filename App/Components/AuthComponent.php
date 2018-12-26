<?php
namespace App\Components;

use App\Entities\Session;
use App\Entities\User;
use App\Repositories\SessionRepository;
use App\Response\Error;

class AuthComponent
{
    private $error;

    public function signIn($username, $password)
    {
        if (!ctype_alnum($username) || !ctype_alnum($password)) {
            $this->error = new Error('Something\'s missing. Please check and try again.');
            return false;
        }
        $user = User::findByUsername($username);

        if (!$user || !password_verify($password, $user->getPassword())) {
            $this->error = new Error('Sorry, those details don\'t match. Check you\'ve typed them correctly.');
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
