<?php
namespace App\Repositories;

use App\Core\Database;

class ArticleRepository
{
    const TABLE = 'articles';

    public static function findAllArticles()
    {
        $sql = '
          SELECT 
            id, title, date, content, image 
          FROM 
            ' . self::TABLE . ' 
          ORDER BY 
            date DESC, id DESC';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function findByArticleId($id)
    {
        $sql = '
          SELECT 
            id, title, date, content, image 
          FROM 
            ' . self::TABLE . ' 
          WHERE 
            id = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchObject(static::class) ? : null;
    }

    public static function create($title, $content, $image)
    {
        $sql = '
          INSERT INTO 
            ' . self::TABLE . ' 
            (title, date, content, image) 
          VALUES 
            (:title, NOW(), :content, :image)';

        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':title' => $title, ':content' => $content, ':image' => $image]);
    }
}
