<?php

namespace App\Amo;

// require_once __DIR__ . '/../../bootstrap.php';

class Amo
{
    public static function CreateLeadsWithContact($dataSave)
    {
        $dataLink = Storage::getToken();

        /** Формируем заголовки */
        $headers = [
            "Content-Type: application/json; charset=utf-8",
            'Authorization: Bearer ' . $dataLink['access_token'],
        ];

        $link = $dataLink['link'] . 'leads/complex'; //Формируем URL для запроса
        $data2 = [
            [
                "name"=> "Тестовая сделка",
                "price"=> (int)$dataSave['price'],
                '_embedded' => [
                    'contacts' => [
                        [
                            "first_name" => $dataSave['name'],
                            "custom_fields_values" => 
                            [
                                [
                                    "field_id"=> 142499,
                                    "values"=> [
                                        [
                                            "value"=> $dataSave['email']
                                        ]
                                    ]
                                ],
                                [
                                    "field_id"=> 142497,
                                    "values"=> [
                                        [
                                            "value"=> $dataSave['phone']
                                        ]
                                    ]
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data2));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try
        {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new \Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            return ['error' => 'Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode()];
        }
    }
}
