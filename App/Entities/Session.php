<?php

namespace App\Entities;

use App\Repositories\SessionRepository;

class Session extends SessionRepository
{
    public static $table = 'sessions';
    private $sessionId;
    private $userId;
    private $expires;

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getExpires()
    {
        return $this->expires;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setExpires($expires)
    {
        $this->expires = $expires;
    }
}
