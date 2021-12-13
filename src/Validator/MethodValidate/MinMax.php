<?php

namespace App\Validator\MethodValidate;

use Exception;

trait MinMax
{
    public function isMinMaxData($data, $length, $type = 'less')
    {
        // Проверяем на кол-во символов максимально и минимально, если type неизвестен обрабатываем исключение
        if($type === 'more'){
            if(mb_strlen($data) <= $length){
                return false;
            }else{
                return "Максимум символов: $length";
            }
        }elseif($type === 'less'){
            if(mb_strlen($data) >= $length){
                return false;
            }else{
                return "Минимум символов: $length";
            }
        }else{
            try{
                throw new Exception("Ошибка в переданных данных");
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
    }
}
