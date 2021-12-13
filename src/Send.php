<?
namespace App;
require_once __DIR__ . '/../bootstrap.php';

use App\Amo\Amo;
use App\Request\Request;
use App\Controller\Controller;
use App\Validator\VueValidate;

class Send
{
    //Данные из формы
    private $request;
    // Для валидации
    private $validate;

    //Создания объекта в констуркторе, для возможности работы с данными
    public function __construct()
    {
        $this->request = new Request();
    }

    //Полученние данных
    private function getRequest()
    {
        return $this->request->get();
    }

    // Отправка данных и их обработка
    public function sendData()
    {
        // Записываем все данные из формы в локальную переменную
        $data = $this->getRequest();
        // Создаем объект валидации
        $this->validate = new VueValidate($data);
        // Указывавем правила валидации
        $errors = $this->validate->validate([
            'name' => ['isEmptyData', 'min:2', 'max:10'],
            'email' => ['isEmptyData', 'isEmailData'],
            'price' => ['isEmptyData', 'isNumericData'],
            'phone' => ['isEmptyData', 'isPhoneData'],
        ]);
        // если есть ошибки в валидации возвращаем их список
        if($errors){
            return $errors;
        }
        // Если ошибок нет, выполняем передачу данных формы в amoCRM
        $amo = Amo::CreateLeadsWithContact($data);
        // Если при передачи ошибок возникли ошибки отдаем их и делаем статус сервера 422
        if($amo){
            $controller = new Controller();
            $controller->response(422);
            return $amo;
        }
        // Если все хорошо просто отдаем success
        return 'success';
        
    }    
}

$send = new Send();
$validate = $send->sendData();
echo(json_encode($validate));




