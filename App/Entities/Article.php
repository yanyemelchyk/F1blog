<?php
namespace App\Entities;

use App\Repositories\ArticleRepository;

class Article extends ArticleRepository
{
    //todo replace table from Entities - only repo should know details about Database
    public static $table = 'articles';
    private $articleId;
    private $title;
    private $date;
    private $content;
    private $image;

    //todo getId -- rename column to id
    public function getArticleId()
    {
        return $this->articleId;
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
