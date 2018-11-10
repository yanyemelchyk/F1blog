<?php
namespace App\Entities;

use App\Repositories\UserRepository;

class User extends UserRepository
{
    public static $table = 'users';

    private $userId;
    private $username;
    private $password;
    private $lastName;
    private $firstName;
    private $picture;

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    function getUserId()
    {
        return $this->userId;
    }

    function getLastName()
    {
        return $this->lastName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getPicture()
    {
        return $this->picture;
    }
}
