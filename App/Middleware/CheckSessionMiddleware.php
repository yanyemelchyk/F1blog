<?php

namespace App\Middleware;

use App\Entities\Session;
use App\Entities\User;

class CheckSessionMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (!isset($_SESSION['user']) && isset($_COOKIE['sessionId'])) {

            $sessionId = $_COOKIE['sessionId'];
            $session = Session::findBySessionId($sessionId);
            $date = new \DateTime();
            $current = $date->format('U');

            if ($session && $current < $session->getExpires()) {
                $user = User::findByUserId($session->getUserId());
                $_SESSION['user'] = $user;
            }
        }
    }
}
