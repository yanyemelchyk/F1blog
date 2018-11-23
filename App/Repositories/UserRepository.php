<?php
namespace App\Repositories;

use App\Core\Database;

class UserRepository
{
    const TABLE = 'users';

    public static function findByUsername($username)
    {
        $sql = '
          SELECT 
            id, username, password 
          FROM 
            ' . self::TABLE . ' 
          WHERE 
            username = :username';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchObject(static::class) ? : null;
    }

    public static function create($username, $password)
    {
        $sql = '
          INSERT INTO 
            ' . self::TABLE . ' 
            (username, password) 
          VALUES 
            (:username, :password)';

        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':username' => $username, ':password' => $password]);
    }

    public static function findByUserId($userId)
    {
        $sql = '
          SELECT 
            username, lastName, firstName, picture 
          FROM 
            ' . self::TABLE . ' 
          WHERE 
            id = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':id' => $userId]);
        return $stmt->fetchObject(static::class);
    }
}
