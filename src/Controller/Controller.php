<?php

namespace App\Controller;
use Exception;

// В текущем классе идёт только обработка кода события header
class Controller
{
    public function response(int $code = 201, array $options = [])
    {
        $httpStatusCode = $code;
        $phpSapiName    = substr(php_sapi_name(), 0, 3);
        $httpStatusMsg  = $options['message'] ?? 'Not correct request';

        if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
            header('Status: '.$httpStatusCode.' '.$httpStatusMsg);
        }else{
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
            header($protocol.' '.$httpStatusCode.' '.$httpStatusMsg);
        }
    }
}