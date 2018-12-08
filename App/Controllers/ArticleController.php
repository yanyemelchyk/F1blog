<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Article;
use App\Exceptions\NotFoundHttpException;
use App\Middleware\CheckSessionMiddleware;
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
        $this->view->render(
            'index.php',
            [
                'title' => 'Formula 1 blog',
                'articles' => Article::findAllArticles()
            ]
        );
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
        $this->view->render(
            'article.php',
            [
                'title' => $article->getTitle(),
                'user' => $user, 'article' => $article,
            ]
        );
    }

    public function createAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = strip_tags($_POST['title']);
            $content = strip_tags($_POST['content']);

            if (!$title) {
                $this->view->errors[] = 'Введите название для статьи';
            }
            if (!$content) {
                $this->view->errors[] = 'Введите содержание статьи';
            }
            if (!$_FILES['image']['name']) {
                $this->view->errors[] = 'Выберите изображение для статьи';
            }
            $allowedMimes = [
                'image/gif',
                'image/jpeg',
                'image/jpg',
                'image/png'
            ];
            if (!in_array($_FILES['image']['type'], $allowedMimes, true) || $_FILES['image']['size'] <= 0) {
                $this->view->errors[] = 'Изображение должно иметь формат GIF, JPEG, или PNG';
            }
            if ($_FILES['image']['error'] !== 0) {
                $this->view->errors[] = 'Проблема с загрузкой файла';
            }
            if (!$this->view->errors) {
                $fileName = ROOT_PATH . UPLOAD_PATH . basename($_FILES['image']['name']);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $fileName)
                    && Article::create($title, $content, $_FILES['image']['name'])) {
                    App::getInstance()->router->redirect('/article/create');
                }
                $this->view->errors[] = 'Ошибка! Статья не загружена!';
            }
        }
            $this->view->render('addArticle.php', ['title' => 'Добавление новой статьи']);
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
