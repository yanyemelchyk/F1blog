<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Article;
use App\Entities\Comment;
use App\Exceptions\Logger;
use App\Exceptions\NotFoundHttpException;
use App\Helpers\Validator;
use App\Repositories\CommentRepository;

class ArticleController extends Controller
{
    public function indexAction()
    {
        $this->sessionInit();
        $app = App::getInstance();
        $validator = new Validator();
        $this->setViewValues('article.php', null);

        try {
            if (!isset($app->router->getParams()['id'])) {
                throw new NotFoundHttpException();
            }
            $id = $validator->clean($app->router->getParams()['id']);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $articleId = $validator->clean($_POST['articleId']);
                $username = $validator->clean($_POST['username']);
                $textComment = $validator->cleanAndCheckEmpty($_POST['textComment'], 'Введите ваш комментарий');

                if ($validator->isErrorEmpty() && CommentRepository::create($articleId, $username, $textComment)) {
                    $app->router->refresh();
                    return;
                } else {
                    if ($validator->getError()) {
                        foreach ($validator->getError() as $error) {
                            $this->view->errorMsg .= $error . '<br>';
                        }
                    } else {
                        $this->view->errorMsg = 'Ошибка при добавлении комментария. Поворите попытку';
                    }
                }
            }
            $article = Article::findById($id);

            if (is_null($article)) {
                throw new NotFoundHttpException();
            }
            $comments = Comment::find($id);

            if (empty($comments)) {
                if (empty($this->view->errorMsg)) {
                    $this->view->errorMsg = 'К этой новости пока нет комментариев';
                }
            }
            $this->view->article = $article;
            $this->view->comments = $comments;
            $this->view->render();
        } catch (NotFoundHttpException $e) {
            Logger::exceptionHandler($e);
        }
    }
}