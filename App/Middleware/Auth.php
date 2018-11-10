<?php
namespace App\Middleware;

use App\Core\App;

class Auth
{
    public static function handle()
    {
        if (!isset($_SESSION['userId'])) {
            $app = App::getInstance();
            $app->router->redirect('/auth/login');
            exit();
        }
        return;
    }
}