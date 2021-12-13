<?php

namespace App\Validator\MethodValidate;

trait Numeric
{
    public function isNumericData($data)
    {
        // проверка на цифры
        if(is_numeric($data)){
            return false;
        }else{
            return "Поле должно быть целым числом";
        }
    }
}