<?php
namespace App\Entities;

use App\Repositories\CommentRepository;

class Comment extends CommentRepository
{
    private $username;
    private $textComment;

    public function getUsername()
    {
        return $this->username;
    }

    public function getTextComment()
    {
        return $this->textComment;
    }
}
