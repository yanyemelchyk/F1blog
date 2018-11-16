<?php

namespace App\Repositories;

use App\Core\Database;

class SessionRepository
{
    public static $table = '';

    public static function createSession($session)
    {
        $sql = '
          INSERT INTO 
            ' . $session::$table . ' 
            (sessionId, userId, expires) 
          VALUES 
            (:sessionId, :userId, :expires)';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':sessionId' => $session->getSessionId(), ':userId' => $session->getUserId(), ':expires' => $session->getExpires()]);
    }

    public static function getSession($sessionId)
    {
        $sql = '
          SELECT 
            userId, expires 
          FROM 
            ' . static::$table . ' 
          WHERE 
            sessionId = :sessionId';

        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([':sessionId' => $sessionId]);
        return $stmt->fetchObject(static::class);
    }
}
