<?php

namespace App\Core;

class Map
{
    private static $routes = [
        'default' => [
            'url' => '',
            'controller' => 'article',
            'action' => 'index'
        ],
        'home' => [
            'url' => 'article/index',
            'controller' => 'article',
            'action' => 'index'
        ],
        'article' => [
            'url' => 'article/show/{id:\d+}',
            'controller' => 'article',
            'action' => 'show'
        ],
        'createArticle' => [
            'url' => 'article/create',
            'controller' => 'article',
            'action' => 'create'
        ],
        'authMain' => [
            'url' => 'auth/index',
            'controller' => 'auth',
            'action' => 'index'
        ],
        'logout' => [
            'url' => 'auth/logout',
            'controller' => 'auth',
            'action' => 'logout'
        ],
        'createUser' => [
            'url' => 'user/create',
            'controller' => 'user',
            'action' => 'create'
        ],
        'showProfile' => [
            'url' => 'user/show',
            'controller' => 'user',
            'action' => 'show'
        ],
        'createComment' => [
            'url' => 'comment/create',
            'controller' => 'comment',
            'action' => 'create'
        ],
        'showComment' => [
            'url' => 'comment/show',
            'controller' => 'comment',
            'action' => 'show'
        ],
        'authLogin' => [
            'url' => 'auth/login',
            'controller' => 'auth',
            'action' => 'login'
        ]
    ];

    public static function getRoutes()
    {
        return self::$routes;
    }
}
