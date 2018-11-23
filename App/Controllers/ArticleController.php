<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Article;
use App\Entities\Comment;
use App\Exceptions\NotFoundHttpException;
use App\Middleware\CheckSessionMiddleware;
use App\Repositories\CommentRepository;
use App\Middleware\AuthMiddleware;

class ArticleController extends Controller
{
    protected function setMiddleware()
    {
        $this->middleware = [
            'createAction' => [
                new CheckSessionMiddleware(),
                new AuthMiddleware()
            ],
            'showAction' => [
                new CheckSessionMiddleware()
            ],
            'indexAction' => [
                new CheckSessionMiddleware()
            ]
        ];
    }

    public function indexAction()
    {
        //this action shows all the articles
        $this->view->template = 'index.php';
        $this->view->title = 'Formula 1 blog';
        $this->view->articles = Article::findAllArticles();
        $this->view->render();
    }

    public function showAction()
    {
        //this action shows the only one
        $articleId = App::getInstance()->router->getParams()['id'];

        if (!ctype_digit($articleId)) {
            throw new NotFoundHttpException();
        }
        $article = Article::findByArticleId($articleId);

        if (is_null($article)) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        $user = $_SESSION['user'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $user->getUsername();
            $textComment = strip_tags($_POST['textComment']);

            if (empty($textComment)) {
                $this->view->errorMsg[] = 'Введите ваш комментарий';
            }
            if (!$this->view->errorMsg && CommentRepository::create($articleId, $username, $textComment)) {
                App::getInstance()->router->refresh();
                return;
            }
        }
        $comments = Comment::findByArticleId($articleId);

        if (empty($comments)) {
            $this->view->errorMsg[] = 'К этой новости пока нет комментариев';
        }
        $this->view->user = $user;
        $this->view->article = $article;
        $this->view->comments = $comments;
        $this->view->template = 'article.php';
        $this->view->title = $article->getTitle();
        $this->view->render();
    }

    public function createAction()
    {
        $this->view->template = 'addArticle.php';
        $this->view->title = 'Добавление новой статьи';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = strip_tags($_POST['title']);
            $content = strip_tags($_POST['content']);

            if (empty($title)) {
                $this->view->errorMsg[] = 'Введите название для статьи';
            }
            if (empty($content)) {
                $this->view->errorMsg[] = 'Введите содержание статьи';
            }
            if (empty($_FILES['image']['name'])) {
                $this->view->errorMsg[] = 'Выберите изображение для статьи';
            }
            $allowedMimes = [
                'image/gif',
                'image/jpeg',
                'image/jpg',
                'image/png'
            ];
            if (!in_array($_FILES['image']['type'], $allowedMimes, true) || $_FILES['image']['size'] <= 0) {
                $this->view->errorMsg[] = 'Изображение должно иметь формат GIF, JPEG, или PNG';
            }
            if ($_FILES['image']['error'] !== 0) {
                $this->view->errorMsg[] = 'Проблема с загрузкой файла';
            }
            if ($this->view->errorMsg) {
                $this->view->render();
                return;
            }
            $fileName = ROOT_PATH . UPLOAD_PATH . basename($_FILES['image']['name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $fileName)
                && Article::create($title, $content, $_FILES['image']['name'])) {
                App::getInstance()->router->redirect('/article/create');
            }
            $this->view->errorMsg[] = 'Ошибка! Статья не загружена!';
            $this->view->render();
            return;
        } else {
            $this->view->render();
        }
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
