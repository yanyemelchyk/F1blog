<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\User;
use App\Middleware\AuthMiddleware;
use App\Middleware\CheckSessionMiddleware;

class ProfileController extends Controller
{
    protected function setMiddleware()
    {
        $this->middleware = [
            'indexAction' => [
                new CheckSessionMiddleware(),
                new AuthMiddleware()
            ],
        ];
    }

    public function indexAction()
    {
        $this->view->template = 'profile.php';
        $this->view->title = 'Профиль пользователя';

        $user = User::read($_SESSION['userId']);
        if (!$user) {
            $this->displayMessage('При загрузке данных профиля произошла ошибка. Повторите попытку');
            return;
        }
        $this->view->user = $user;
        $this->view->render();
    }
}
