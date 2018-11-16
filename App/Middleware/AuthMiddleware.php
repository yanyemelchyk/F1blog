<?php
namespace App\Middleware;

use App\Core\App;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (!isset($_SESSION['userId'])) {
            App::getInstance()->router->redirect('/auth/login');
            exit();
        }
        return;
    }
}
