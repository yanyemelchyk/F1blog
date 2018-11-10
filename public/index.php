<?php

const ROOT_PATH = __DIR__;
require ROOT_PATH . '/../Config.php';
require ROOT_PATH . '/../vendor/autoload.php';

set_exception_handler('App\Exceptions\Logger::exceptionHandler');

$app = App\Core\App::getInstance();
$app->route();
