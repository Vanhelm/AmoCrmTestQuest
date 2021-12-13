<?php 
namespace App\Validator;

use App\Controller\Controller;
use App\Validator\MethodValidate\Email;
use App\Validator\MethodValidate\Numeric;
use App\Validator\MethodValidate\Required;
use App\Validator\MethodValidate\MinMax;
use App\Validator\MethodValidate\Phone;

abstract class Validator extends Controller
{
    // Подключение трейтов
    use Required, Numeric, Email, MinMax, Phone;

    // Ошибки
    private $errors = [];

    // Функция, которая должна использоваться в наследниках обязательно
    abstract function validate(array $request) :array;

    // Добавляем ошибки
    public function addError($key, $message) {
        $this->errors[$key][] = $message;
    }
    // Получаем ошибки
    public function getErrors() {
        return $this->errors;
    }
}
