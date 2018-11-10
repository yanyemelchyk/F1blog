<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\User;
use App\Middleware\Auth;

class ProfileController extends Controller
{
    public function indexAction()
    {
        $this->sessionInit();
        $this->setViewValues('profile.php', 'Профиль пользователя');
        $this->middleware(Auth::class);
        $user = User::read($_SESSION['userId']);
        if (!$user) {
            $this->displayMessage('При загрузке данных профиля произошла ошибка');
            return;
        }
        $this->view->user = $user;
        $this->view->render();
    }
}
