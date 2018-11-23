<?php

namespace App\Repositories;

use App\Core\Database;

class SessionRepository
{
    const TABLE = 'sessions';

    public static function create($session)
    {
        $sql = '
          INSERT INTO 
            ' . self::TABLE . ' 
            (id, userId, expires) 
          VALUES 
            (:id, :userId, :expires)';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':id' => $session->getId(), ':userId' => $session->getUserId(), ':expires' => $session->getExpires()]);
    }

    public static function findBySessionId($sessionId)
    {
        $sql = '
          SELECT 
            userId, expires 
          FROM 
            ' . self::TABLE . ' 
          WHERE 
            id = :id';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':id' => $sessionId]);
        return $stmt->fetchObject(static::class);
    }
}
