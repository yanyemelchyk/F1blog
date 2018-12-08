<?php
namespace App\Repositories;

use App\Core\Database;

class CommentRepository
{
    const TABLE = 'comments';

    public static function create($articleId, $username, $textComment, $dateComment)
    {
        $sql = '
            INSERT INTO 
              ' . self::TABLE . ' 
            SET 
              articleId = :articleId, username = :username, textComment = :textComment, dateComment = :dateComment';

        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':articleId' => $articleId, ':username' => $username, ':textComment' => $textComment, ':dateComment' => $dateComment]);
    }

    public static function findByArticleId($articleId, $excludeIds)
    {
        $sql = '
            SELECT 
              id, articleId, username, textComment, dateComment 
            FROM 
              ' . self::TABLE . ' 
            WHERE 
              articleId = :articleId 
            AND id NOT IN (' . $excludeIds . ')';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':articleId' => $articleId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
