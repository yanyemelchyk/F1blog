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
        $userAuthorized = isset($_SESSION['user']) ? true : false;
        $this->view->render(
            'index.php',
            [
                'title' => 'Formula 1 blog',
                'userAuthorized' => $userAuthorized,
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
        $user = null;
        $userAuthorized = false;

        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $userAuthorized = true;
        }
        $this->view->render(
            'article.php',
            [
                'title' => $article->getTitle(),
                'user' => $user,
                'userAuthorized' => $userAuthorized,
                'article' => $article
            ]
        );
    }

    public function createAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = strip_tags($_POST['title']);
            $content = strip_tags($_POST['content']);

            if (!$title) {
                echo json_encode(array('message' => 'Введите название для статьи'));
                return;
            }
            if (!$content) {
                echo json_encode(array('message' => 'Введите содержание статьи'));
                return;
            }
            if (!$_FILES['image']['name']) {
                echo json_encode(array('message' => 'Выберите изображение для статьи'));
                return;
            }
            $allowedMimes = [
                'image/gif',
                'image/jpeg',
                'image/jpg',
                'image/png'
            ];
            if (!in_array($_FILES['image']['type'], $allowedMimes, true) || $_FILES['image']['size'] <= 0) {
                echo json_encode(array('message' => 'Изображение должно иметь формат GIF, JPEG, или PNG'));
                return;
            }
            if ($_FILES['image']['error'] !== 0) {
                echo json_encode(array('message' => 'Проблема с загрузкой файла'));
                return;
            }
            $fileName = ROOT_PATH . '/' . UPLOAD_PATH . '/' . basename($_FILES['image']['name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $fileName)
                && Article::create($title, $content, $_FILES['image']['name'])) {
                echo json_encode(array('success' => true, 'message' => 'Статья успешно добавлена'));
                return;
            }
            echo json_encode(array('message' => 'Ошибка! Статья не загружена!'));
            return;
        }
        $this->view->render('addArticle.php', ['title' => 'Добавление новой статьи', 'userAuthorized' => true]);
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
