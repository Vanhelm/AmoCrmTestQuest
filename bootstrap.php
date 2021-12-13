<?php
// Показывать все ошибки
error_reporting(E_ALL);
ini_set('display_errors',true);

// Автозагрузка
function library($className) {
    $filename = $className .".php";
    $path = str_replace('\\', '/', $filename);
    $path = str_replace('App/', 'src/', $path);
    if(strpos($path, 'src') !== false){
        require_once $path;
    }
    
}
spl_autoload_register('library');

// функция для дампа
function dump($value){
    print_r("<pre>");
    print_r($value);
    print_r("</pre>");
}