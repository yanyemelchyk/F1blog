<?php
namespace App\Repositories;

use App\Core\Database;

class UserRepository
{
    public static $table = '';

    //todo rename to findByUsername
    public static function login($username)
    {
        $sql = '
          SELECT 
            userId, username, password 
          FROM 
            ' . static::$table . ' 
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
            ' . static::$table . ' 
            (username, password) 
          VALUES 
            (:username, :password)';

        $stmt = Database::getInstance()->prepare($sql);
        return $stmt->execute([':username' => $username, ':password' => $password]);
    }

    //todo reaname to find
    public static function read($userId)
    {
        $sql = '
          SELECT 
            username, lastName, firstName, picture 
          FROM 
            ' . static::$table . ' 
          WHERE 
            userId = :userId';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchObject(static::class);
    }

    //todo ambiguous - use self::login()
    public static function findByName($username)
    {
        $sql = '
          SELECT 
            username 
          FROM 
            ' . static::$table . ' 
          WHERE 
            username = :username';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchObject(static::class);
    }
}
