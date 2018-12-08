<?php
namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Entities\Comment;
use App\Exceptions\NotFoundHttpException;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    public function setMiddleware()
    {
        // TODO: Implement setMiddleware() method.
    }

    public function createAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $articleId = $_POST['articleId'];
            $textComment = strip_tags($_POST['textComment']);
            $date = new \DateTime();
            $dateComment = $date->format('Y-m-d H:i:s');

            if (!ctype_alnum($username) || !ctype_digit($articleId)) {
                die(json_encode(array('message' => 'Ошибка при добавлении комментария')));
            }
            if (!$textComment) {
                die(json_encode(array('message' => 'Введите текст комментария')));
            }
            CommentRepository::create($articleId, $username, $textComment, $dateComment);
            echo json_encode(array('success' => true, 'message' => 'Комментарий добавлен'));
        }
    }

    public function showAction()
    {
        $articleId = $_POST['articleId'];

        if (isset($_POST['excludeIds'])) {
            $excludeIds = implode(', ', $_POST['excludeIds']);
        } else {
            $excludeIds = '1';
        }
        $comments = Comment::findByArticleId($articleId, $excludeIds);
        echo json_encode(array('comments' => $comments));
    }
}
