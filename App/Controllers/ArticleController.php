<?php

namespace App\Controllers;

use App\Response\Error;
use App\Core\App;
use App\Core\Controller;
use App\Entities\Article;
use App\Exceptions\NotFoundHttpException;
use App\Middleware\CheckSessionMiddleware;
use App\Middleware\AuthMiddleware;
use App\Response\JsonResponse;

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
        $user = isset($_SESSION['user']);
        $this->view->render(
            'index.php',
            [
                'title' => 'Formula 1 blog - Homepage',
                'user' => $user,
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
            throw new NotFoundHttpException('Page not found');
        }
        $user = $_SESSION['user'] ?? false;
        $this->view->render(
            'article.php',
            [
                'title' => $article->getTitle(),
                'user' => $user,
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
                return new JsonResponse(new Error('Enter a title for the article.'), 400);
            }
            if (!$content) {
                return new JsonResponse(new Error('Enter the content of the article.'), 400);
            }
            if (!$_FILES['image']['name']) {
                return new JsonResponse(new Error('Select an image for the article'),400);
            }
            $allowedMimes = [
                'image/gif',
                'image/jpeg',
                'image/jpg',
                'image/png'
            ];
            if (!in_array($_FILES['image']['type'], $allowedMimes, true) || $_FILES['image']['size'] <= 0) {
                return new JsonResponse(new Error('The image must be formatted as GIF, JPEG, или PNG'), 400);
            }
            if ($_FILES['image']['error'] !== 0) {
                return new JsonResponse(new Error('File download issue'), 400);
            }
            $fileName = ROOT_PATH . '/' . UPLOAD_PATH . '/' . basename($_FILES['image']['name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $fileName)
                && Article::create($title, $content, $_FILES['image']['name'])) {
                return new JsonResponse();
            }
            return new JsonResponse(new Error('The article is not loaded!'), 400);
        }
        $this->view->render('addArticle.php', ['title' => 'F1blog - Adding a new article', 'user' => true]);
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}
