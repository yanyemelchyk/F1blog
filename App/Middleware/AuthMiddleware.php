<?php
namespace App\Middleware;

use App\Core\App;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (!isset($_SESSION['userId'])) {
            $app = App::getInstance();
            //todo its time to replace real urls by Router method
            $app->router->redirect('/auth/login');
            exit();
        }
    }
}