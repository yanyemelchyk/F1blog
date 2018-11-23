<?php
namespace App\Repositories;

use App\Core\Database;

class CommentRepository
{
    const TABLE = 'comments';

    public static function create($articleId, $username, $textComment)
    {
        $sql = '
            INSERT INTO 
              ' . self::TABLE . ' 
            SET 
              articleId = :articleId, username = :username, textComment = :textComment';

        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':articleId' => $articleId, ':username' => $username, ':textComment' => $textComment]);
    }

    public static function findByArticleId($articleId)
    {
        $sql = '
            SELECT 
              id, articleId, username,textComment 
            FROM 
              ' . self::TABLE . ' 
            WHERE 
              articleId = :articleId';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':articleId' => $articleId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }
}
