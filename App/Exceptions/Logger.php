<?php
namespace App\Exceptions;

use App\Views\View;

class Logger
{
    public static function exceptionHandler(\Throwable $exception)
    {
        $code = $exception->getCode();
        if ($code !== 404) {
            $code = 500;
        }
        http_response_code($code);
        self::log($exception);
        $view = new View;
        $view->render($code . '.html', ['title' => 'Formula 1 blog']);
    }

    private static function log($exception)
    {
        $date = new \DateTime();
        $log = ROOT_PATH . '/../logs/' . $date->format('Y-m-d') . '.txt';
        ini_set('error_log', $log);
        $message = 'Uncaught exception: "' . get_class($exception) . '" with message "' . $exception->getMessage() . PHP_EOL;
        $message .= 'Stack trace: ' . $exception->getTraceAsString() . PHP_EOL;
        $message .= 'Thrown in "' . $exception->getFile() . '" on line ' . $exception->getLine() . PHP_EOL;
        error_log($message);
    }
}
