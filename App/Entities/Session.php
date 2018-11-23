<?php

namespace App\Entities;

use App\Repositories\SessionRepository;

class Session extends SessionRepository
{
    private $id;
    private $userId;
    private $expires;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getExpires()
    {
        return $this->expires;
    }

    public function setId($id)
    {
        $this->id = $id;
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
