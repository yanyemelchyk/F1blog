<?php
namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Article;
use App\Helpers\Validator;
use App\Middleware\AuthMiddleware;

//todo no. U should have the ArticleController with actions index, add, edit, delete.
class AddArticleController extends Controller
{
    protected function setMiddleware()
    {
        $this->middleware = [
            'indexAction' => [
                //todo note that order of middleware is important - auth should be first
                new AuthMiddleware()
            ],
        ];
    }

    public function indexAction()
    {
        $this->setViewValues('addArticle.php', 'Добавление новой статьи');

        //todo u should check user ALWAYS, not only in GET request -- see how u did it before
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = new Validator();

            $title = $validator->cleanAndCheckEmpty($_POST['title'], 'Введите название для статьи');
            $content = $validator->cleanAndCheckEmpty($_POST['content'], 'Введите содержание статьи');
            $validator->checkImage($_FILES['image']);

            if (!$validator->isErrorEmpty()) {
                $this->displayMessage($validator->getHtmlMessage());
                return;
            }
            //todo naming is VERY imprtant. I dont know what target is. var name like fileName etc better
            $target = ROOT_PATH . UPLOAD_PATH . basename($_FILES['image']['name']);

            //todo how will u handle situation if move_uploaded_file returns false ? same as normal behavior for end-user
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                if (!Article::create($title, $content, $_FILES['image']['name'])) {
                    $this->displayMessage('Ошибка! Статья не загружена!');
                    return;
                }
            }

//            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)
//                && Article::create($title, $content, $_FILES['image']['name'])) {
//                    App::getInstance()->router->redirect('/addArticle');
//                }
//
//            $this->displayMessage('Ошибка! Статья не загружена!');
//            return;



            App::getInstance()->router->redirect('/addArticle');
            //todo check that script wont get on this line. After redirect script should be done
        }

        $this->view->render();
    }
}