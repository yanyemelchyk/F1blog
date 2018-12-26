<?php
namespace App\Middleware;

use App\Core\App;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            App::getInstance()->router->redirect('/auth/index');
        }
        return;
    }
}
