<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Article;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->sessionInit();
        $this->setViewValues('index.php', 'Formula 1 blog');
        $this->view->articles = Article::findAll();
        $this->view->render();
    }
}