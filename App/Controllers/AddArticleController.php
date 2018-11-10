<?php
namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Article;
use App\Helpers\Validator;
use App\Middleware\Auth;

class AddArticleController extends Controller
{
    public function indexAction()
    {
        $this->sessionInit();
        $app = App::getInstance();
        $this->setViewValues('addArticle.php', 'Добавление новой статьи');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = new Validator();

            $title = $validator->cleanAndCheckEmpty($_POST['title'], 'Введите название для статьи');
            $content = $validator->cleanAndCheckEmpty($_POST['content'], 'Введите содержание статьи');
            $validator->checkImage($_FILES['image']);

            if (!$validator->isErrorEmpty()) {
                $this->displayMessage($validator->getMessage());
                return;
            }
            $target = ROOT_PATH . UPLOAD_PATH . basename($_FILES['image']['name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                if (!Article::create($title, $content, $_FILES['image']['name'])) {
                    $this->displayMessage('Ошибка! Статья не загружена!');
                    return;
                }
            }
            $app->router->redirect('/addArticle');
        } else {
            $this->middleware(Auth::class);
            $this->view->render();
        }
    }
}