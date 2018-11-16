<?php

namespace App\Middleware;

use App\Entities\Session;
use App\Entities\User;

class CheckSessionMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (!isset($_SESSION['userId']) && isset($_COOKIE['sessionId'])) {

            $sessionId = $_COOKIE['sessionId'];
            $session = Session::getSession($sessionId);
            $date = new \DateTime();
            $current = $date->format('U');

            if ($session && $current < $session->getExpires()) {
                $user = User::read($session->getUserId());
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['userId'] = $session->getUserId();
            }
        }
        return;
    }
}
