<?php
namespace App\Repositories;

use App\Core\Database;
use App\Exceptions\DbException;

class ArticleRepository
{
    public static $table = '';

    public static function findAll()
    {
        $sql = '
          SELECT 
            articleId, title, date, content, image 
          FROM 
            ' . static::$table . ' 
          ORDER BY 
            date DESC, articleId DESC';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function findById($id)
    {
        $sql = '
          SELECT 
            articleId, title, date, content, image 
          FROM 
            ' . static::$table . ' 
          WHERE 
            articleId = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchObject(static::class) ? : null;
    }

    public static function create($title, $content, $image)
    {
        $sql = '
          INSERT INTO 
            ' . static::$table . ' 
            (title, date, content, image) 
          VALUES 
            (:title, NOW(), :content, :image)';

        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':title' => $title, ':content' => $content, ':image' => $image]);
    }
}
