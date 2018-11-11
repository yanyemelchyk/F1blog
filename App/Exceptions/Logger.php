<?php
namespace App\Exceptions;

use App\Views\View;

class Logger
{
    public static function exceptionHandler(\Throwable $exception)
    {
        $code = $exception->getCode();
        //todo !==
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);
        self::log($exception);
        $view = new View;
        $view->template = $code . '.html';
        $view->title = 'Formula 1 blog';
        $view->render();
    }

    private static function log($exception)
    {
        $date = new \DateTime();
        $log = ROOT_PATH . '/../logs/' . $date->format('Y-m-d') . '.txt';
        ini_set('error_log', $log);
        $message = "Uncaught exception: '" . get_class($exception) . "'";
        $message .= " with message '" . $exception->getMessage() . "'";
        $message .= "\nStack trace: " . $exception->getTraceAsString();
        //todo \n can be replace by PHP_EOF - just to know that
        $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "\n";
        error_log($message);
    }
}
