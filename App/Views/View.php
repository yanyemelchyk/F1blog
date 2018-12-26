<?php

namespace App\Views;

use App\Core\App;

class View
{
    public $data = [];
    private $template;
    private $router;

    public function __construct()
    {
        $this->router = App::getInstance()->router;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        return $this->data[$key];
    }

    public function render($template, array $params)
    {
        $this->template = $template;

        foreach ($params as $key=>$value) {
            $this->{$key} = $value;
        }
        ob_start();
        include ROOT_PATH . '/../App/Views/layout/template.php';
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
