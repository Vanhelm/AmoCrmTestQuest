<?php

namespace App\Validator\MethodValidate;

trait Required
{
    public function isEmptyData($data)
    {
        // Проверка на не пустое поле
        if(!empty(trim($data))){
            return false;
        }else{
            return "Поле обязательно для заполнения";
        }
    }
}