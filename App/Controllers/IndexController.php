<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Article;
use App\Middleware\CheckSessionMiddleware;

class IndexController extends Controller
{
    protected function setMiddleware()
    {
        $this->middleware = [
            'indexAction' => [
                new CheckSessionMiddleware()
            ],
        ];
    }

    public function indexAction()
    {
        $this->view->template = 'index.php';
        $this->view->title = 'Formula 1 blog';
        $this->view->articles = Article::findAll();
        $this->view->render();
    }
}
