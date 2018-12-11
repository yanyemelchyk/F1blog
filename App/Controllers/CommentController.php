<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Comment;
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
                echo json_encode(array('message' => 'Ошибка при добавлении комментария'));
                return;
            }
            if (!$textComment) {
                echo json_encode(array('message' => 'Введите текст комментария'));
                return;
            }
            CommentRepository::create($articleId, $username, $textComment, $dateComment);
            echo json_encode(array('success' => true, 'message' => 'Комментарий добавлен'));
        }
    }

    public function showAction()
    {
        $articleId = $_POST['articleId'];

        if (!ctype_digit($articleId)) {
            echo json_encode(array('message' => 'Ошибка при выводе комментариев'));
            return;
        }
        $excludeIds[] = 1;

        if (isset($_POST['excludeIds'])) {
            foreach ($_POST['excludeIds'] as $id) {
                if (!ctype_digit($id)) {
                    echo json_encode(array('message' => 'Invalid excludeIds'));
                    return;
                }
            }
            $excludeIds = $_POST['excludeIds'];
        }
        $comments = Comment::findByArticleId($articleId, $excludeIds);
        echo json_encode(array('comments' => $comments));
    }
}
