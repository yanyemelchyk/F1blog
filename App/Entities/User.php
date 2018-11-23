<?php
namespace App\Entities;

use App\Repositories\UserRepository;

class User extends UserRepository
{
    private $id;
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

    function getId()
    {
        return $this->id;
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
