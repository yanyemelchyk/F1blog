<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Article;
use App\Entities\Comment;
use App\Exceptions\NotFoundHttpException;
use App\Helpers\Validator;
use App\Middleware\CheckSessionMiddleware;
use App\Repositories\CommentRepository;
use App\Middleware\AuthMiddleware;

class ArticleController extends Controller
{
    protected function setMiddleware()
    {
        $this->middleware = [
            'addAction' => [
                new CheckSessionMiddleware(),
                new AuthMiddleware()
            ],
            'indexAction' => [
                new CheckSessionMiddleware()
            ]
        ];
    }

    public function indexAction()
    {
        $validator = new Validator();

        if (!isset(App::getInstance()->router->getParams()['id'])) {
            throw new NotFoundHttpException();
        }
        $id = $validator->clean(App::getInstance()->router->getParams()['id']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $articleId = $validator->clean($_POST['articleId']);
            $username = $validator->clean($_POST['username']);
            $textComment = $validator->clean($_POST['textComment']);
            $validator->checkEmpty($textComment, 'Введите ваш комментарий');

            if (!$validator->getError() && CommentRepository::create($articleId, $username, $textComment)) {
                App::getInstance()->router->refresh();
                return;
            }
            if ($validator->getError()) {
                foreach ($validator->getError() as $error) {
                    $this->view->errorMsg[] = $error;
                }
            } else {
                $this->view->errorMsg[] = 'Ошибка при добавлении комментария. Поворите попытку';
            }
        }
        $article = Article::findById($id);

        if (is_null($article)) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        $comments = Comment::find($id);

        if (empty($comments)) {
            $this->view->errorMsg[] = 'К этой новости пока нет комментариев';
        }
        $this->view->article = $article;
        $this->view->comments = $comments;
        $this->view->template = 'article.php';
        $this->view->title = $article->getTitle();
        $this->view->render();
    }

    public function addAction()
    {
        $this->view->template = 'addArticle.php';
        $this->view->title = 'Добавление новой статьи';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = new Validator();
            $title = $validator->clean($_POST['title']);
            $content = $validator->clean($_POST['content']);
            $validator->checkEmpty($title, 'Введите название для статьи');
            $validator->checkEmpty($content, 'Введите содержание статьи');
            $validator->checkImage($_FILES['image']);

            if ($validator->getError()) {
                $this->displayMessage($validator->getError());
                return;
            }
            $fileName = ROOT_PATH . UPLOAD_PATH . basename($_FILES['image']['name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $fileName)
                && Article::create($title, $content, $_FILES['image']['name'])) {
                App::getInstance()->router->redirect('/article/add');
            }
            $this->displayMessage('Ошибка! Статья не загружена!');
            return;
        } else {
            $this->view->render();
        }
    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}
