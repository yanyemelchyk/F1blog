<?php
namespace App\Entities;

use App\Repositories\ArticleRepository;

class Article extends ArticleRepository
{
    private $id;
    private $title;
    private $date;
    private $content;
    private $image;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getImage()
    {
        return $this->image;
    }
}
