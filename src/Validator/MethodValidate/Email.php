<?php

namespace App\Validator\MethodValidate;

trait Email
{
    public function isEmailData($data)
    {   
        // Проверяем email
        if(isset($data) && filter_var($data, FILTER_VALIDATE_EMAIL)){
            return false;
        }else{
            return "Email некорректен";
        }
    }
}