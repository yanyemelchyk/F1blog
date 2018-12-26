<?php

namespace App\Controllers;

use App\Response\Error;
use App\Response\JsonResponse;
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
                return new JsonResponse(new Error('Only Latin letters and numbers are allowed.'), 400);
            }
            if ($password !== $password2) {
                return new JsonResponse(new Error('Password and confirmation do not match.'), 400);
            }
            if (User::findByUsername($username)) {
                return new JsonResponse(new Error('A user with this login already exists.'), 400);
            }
            $password = password_hash($password, PASSWORD_DEFAULT);

            if (!User::create($username, $password)) {
                return new JsonResponse(new Error('An error occurred while creating the user. Try again.'), 400);
            }
            return new JsonResponse();
        }
        $this->view->render('register.php', ['title' => 'F1blog - Register', 'user' => false]);
    }

    public function showAction()
    {
        $user = User::findByUserId($_SESSION['user']->getId());
        $this->view->render('profile.php', ['title' => 'F1blog - My profile', 'user' => $user]);
    }
}
