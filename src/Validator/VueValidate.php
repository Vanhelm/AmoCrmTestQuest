<?php
namespace App\Validator;

use App\Request\Request;
use Exception;

// Наследуемся от базового класса валидатор
class VueValidate extends Validator
{
    // Данные из формы
    private $request = [];

    // Данные из формы получаем в конструкторе
    public function __construct($request)
    {
        $this->request = $request;
    }

    // Валидация, возращаем массив
    public function validate(array $request) :array
    {
        // Обхявление локальной переменной
        $error = null;
        // Перебираем данные валидации(методы валидатора)
        foreach($request as $key => $value){
            // В обрабочке ошибок, если ошибка есть в данных заполняем массив с ошибками
            try{
                // Проверяем есть ли ключ валидатора в массиве с формой, если есть продолжаем, если нет прерываем дальнейшие действие
                if(!array_key_exists($key, $this->request)){
                    throw new Exception("Отсутствующий ключ в обработчике данных");
                    break;
                }else{
                    // Сброс ошибки
                    $error = null;
                    // Перебираем поля валидатора
                    foreach($value as $k => $val){
                        // Проверяем если значение min or max, то выводим отдельную функцию для него
                        if(strpos($val, 'min') !== false || strpos($val, 'max') !== false){
                            // Создаем массив из строки
                            $minMax = explode(':', $val);
                            // Изначально делаем type min
                            $more = 'less';
                            // Если type max, переопреляем переменную
                            if($minMax[0] === 'max'){
                                $more = 'more';
                            }
                            // Проверяем данные в методе валидатора, если всё успешно продолжаем дальше, если ошибка найдена, то записываем в ошибки
                            $error = $this->isMinMaxData($this->request[$key], $minMax[1], $more);
                            if($error !== false){
                                $this->addError($key, $error);
                            }
                        }else{
                            // Вызываем функцию по имени, передаем параметры
                            $error = $this->{$val}($this->request[$key]);
                            // Если есть ошибки в валидаторе, то отображаем их
                            if($error !== false){
                                $this->addError($key, $error);
                            }
                        }
                    }
                }   
                // Обработка исключения
            }catch(Exception $e){
                return ['error' => $e->getMessage()];
            }
        }
        $error = $this->getErrors();
        if($error){
            $this->response(422);
            return $error;
        }else{
            return [];
        }
        
    }
}