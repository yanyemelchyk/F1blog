<?php
namespace App\Views;

use App\Helpers\UrlHelper;

class View
{
    public $data = [];
    public $errorMsg = '';
    public $title;
    public $template;
    public $url;

    public function __construct()
    {
        $this->url = new UrlHelper();
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        return $this->data[$key];
    }

    //todo refactoring in next iteration
    public function render()
    {
        if (is_null($this->title)) {
            $this->setTitle();
        }
        ob_start();
        include ROOT_PATH . '/../App/Views/layout/template.php';
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    private function setTitle()
    {
        if (isset($this->article)) {
            $this->title = $this->article->getTitle();
        }
    }
}
