<?php

namespace App\Validator\MethodValidate;

trait Phone
{
    public function isPhoneData($data)
    {
        // Регулярка на проверку телефона
        if(preg_match('/^\+7 [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}$/', $data)){
            return false;
        }else{
            return "Формат поля телефон неверен";
        }
    }
}