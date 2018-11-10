<?php
namespace App\Helpers;

class UrlHelper
{

    public function to($route = null, array $params = null)
    {
        $url = '/';

        if (is_null($route)) {
            return $url;
        }

        $url .= $route;

        if (is_null($params)) {
            return $url;
        }

        foreach ($params as $key => $value) {
            $url .= "/$key/$value";
        }

        return $url;
    }
}