<?php

namespace App\Response;

class JsonResponse
{
    public function __construct($data = null, $status = 200)
    {
        $this->setJson($data, $status);
    }

    private function setJson($data, $status)
    {
        http_response_code($status);
        echo json_encode($data);
    }
}
