<?php
namespace App\Controllers;

use App\Response\Error;
use App\Core\Controller;
use App\Entities\Comment;
use App\Repositories\CommentRepository;
use App\Response\JsonResponse;

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
                return new JsonResponse(new Error('The comment is not added'), 400);
            }
            if (!$textComment) {
                return new JsonResponse(new Error('Enter comment text'), 400);
            }
            CommentRepository::create($articleId, $username, $textComment, $dateComment);
            return new JsonResponse();
        }
    }

    public function showAction()
    {
        $articleId = $_POST['articleId'];

        if (!ctype_digit($articleId)) {
            throw new \InvalidArgumentException('Invalid articleId');
        }
        $excludeIds[] = 1;

        if (isset($_POST['excludeIds'])) {
            foreach ($_POST['excludeIds'] as $id) {
                if (!ctype_digit($id)) {
                    throw new \InvalidArgumentException('Invalid commentId');
                }
            }
            $excludeIds = $_POST['excludeIds'];
        }
        $comments = Comment::findByArticleId($articleId, $excludeIds);
        return new JsonResponse(['comments' => $comments]);
    }
}
