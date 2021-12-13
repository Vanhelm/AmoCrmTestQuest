<?php

namespace App\Request;

class Request
{
    private $body = null;
    
    // Записываем в переменную полученные данные из vue в виде ассоциативного массива
    public function __construct()
    {
        $this->body = json_decode(file_get_contents('php://input'), true);
    }

    // Отдаем данные
    public function get()
    {
        return $this->body;
    }

    // Отдаем данные если понадобится одна переменная, если переменная не существует заносим её в массив и отдаем значение null
    function __get($property) 
    {
        if(!isset($this->body[$property])){
            $this->body[$property] = 'null';
        }
        return $this->body[$property];
    }
}