<?php

namespace App\Response;

class Error implements \JsonSerializable
{
    private $error;

    public function __construct($message)
    {
        $this->error = $message;
    }

    public function jsonSerialize()
    {
        $data = [];
        $data['message'] = $this->error;
        return $data;
    }
}
