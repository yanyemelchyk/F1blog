<?php

namespace App\Repositories;

use App\Core\Database;

class CommentRepository
{
    public static function create($articleId, $username, $textComment)
    {
        //todo in ArticleRepo u use static::$table but here comments specified explicitly - be consistent
        $sql = '
              INSERT INTO 
                comments 
              SET 
              articleId = :articleId, username = :username, textComment = :textComment';

        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':articleId' => $articleId, ':username' => $username, ':textComment' => $textComment]);
    }

    //todo wrong -- find should search by id (commentId). If u want to find by articleId - crate findByArticle() method
    public static function find($id)
    {
        $sql = '
              SELECT 
                id, articleId, username,textComment 
              FROM 
                comments 
              WHERE 
                articleId = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }
}
