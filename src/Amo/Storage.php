<?php

namespace App\Amo;

class Storage
{
    // Переменные должны быть нулевые и получаться в методе get_token(), но так как в этом проекте сохранение не реализовано, записываем в переменную
    private static $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg3ZGMyMGM0MjY4NGI5NGYxZTQwM2NjYTNhN2ZiNzkwOGYwNmUxMjEzNjUzMTdjYmI5MjljNDViOWQ4N2NmNjJlNGIzNzA2NDkyZWMxN2YzIn0.eyJhdWQiOiIzZDdjODBhYy1kMmE1LTQ4NDQtYWU0NC0wNjBiYjNhODJlNTciLCJqdGkiOiI4N2RjMjBjNDI2ODRiOTRmMWU0MDNjY2EzYTdmYjc5MDhmMDZlMTIxMzY1MzE3Y2JiOTI5YzQ1YjlkODdjZjYyZTRiMzcwNjQ5MmVjMTdmMyIsImlhdCI6MTYzOTM3MDcyNiwibmJmIjoxNjM5MzcwNzI2LCJleHAiOjE2Mzk0NTcxMjYsInN1YiI6Ijc3MTk0MzMiLCJhY2NvdW50X2lkIjoyOTg3MTk4OCwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.jozKJ5MBWTNk9r_G694u0BhDKFd5G-ZqYfWBkHESuvhZTFNzNIh4ZzYY60GnA2BUPekY6pbi_jZAfkkP7_aELhWWQWw3JkbK1jpZojKXU2_hNqQDWXkjAmYPnSXRp0DRN84-36QHejhUgMYubpZlb35ZLWqvyAs9aKgX0C4Okahbo5ks0l6nQzk-Nh7ZmYQxt984Vfb4_YslpeQ6k41p1qd2X2VXie_oIUZ7efB5G7zfQ1p5aJxgiUy-Ibe_HSOcZjNXLR9D-vOCRVKs-oAWXvDdbc37-2WrIqnxZ9yM3tOOWzF8URvQiUKvQx-kqua2uK1HJge2CUd-rzBbu1KlDw';
    private static $link = 'https://mpohilchuk2.amocrm.ru/api/v4/'; //Формируем URL для запроса;
    private static $client_id = '3d7c80ac-d2a5-4844-ae44-060bb3a82e57';
    private static $client_secret = 'us6JRQZ5Kz56mtxcCplJsjsCH8gTY4kIjWtqXjZusurNrL4y69jTObZfzEZtVbh5';
    private static $refreshToken = 'def50200708742cf215c6fe74b2bc0ac1ea264b2f28652c0b7ae3007759a903527992254da315195dc62992935d7ad48a0734b7dac323e630106d5c066554ae253960044b194b7386a7ad6c4dba80213d47b9a0fdada3fa050cfebaae1baddb9992374fb7130640fad21d7ed8e228c31e91d5e3d04c6effa4c3a3c561f19c9dc1678990bef932c2c4a5d6fc8954fbee3bac765281b0b9b8ad67daee2f1efa14771c21b1421e35ae979fb7476fdbea526903f06416569f3bebf5aebfe29b8c4c635c65caa2b4dd446f1f50828a4c8547bd390600044857dca8283b2632153c7506ba008c0bdff570806fee3eef6534278fb691160ba8897358ac20542cbcea028d5b5e1e5c358a96708b00ffceb83ca809057618d13a3e9ba7d7567327896bc81d9614ee34c7e6522bf5e3613fedbc5c88268f03b10c6ef7a4553fedad9441fb349e9f7ad169a1717883adf3ac6181cca0f01efa71240b9570baf00ff5f66bd06712fad70e8888d5c161cbe6e81a5509652561a7b0a0c97b62ad34c9d516f6b24ff390dbb6ebaadbed3ace0ae9a03ae8788bb84d821b01c754a870818a70ef546d7c7cdda82f1ad55c4102d8cb9c828a9b1de70ebde5c214effcb6bd3d1b97e38ebbff7969f524d063687';

    // Сохранение токена
    public static function saveToken($response)
    {
        //Сохранение токена(база данных, файл, отправка на почту, локальное хранилище и т.д.)
    }
    // Получение данных
    public static function getToken()
    {
        return ['access_token' => self::$access_token, 'link' => self::$link, 'client_id' => self::$client_id, 'client_secret' => self::$client_secret];
    }

    // Создание токена
    public static function createToken()
    {
        $state = 'testerHash95236kkhe23';
        header('location: https://www.amocrm.ru/oauth?client_id={self::$client_id}&state={$state}');
    }

    // Обновление токена
    public static function refreshToken()
    {
        $subdomain = 'test'; //Поддомен нужного аккаунта
        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

        /** Соберем данные для запроса */
        $data = [
            'client_id' => self::$client_id,
            'client_secret' => self::$client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => self::$refreshToken,
            'redirect_uri' => 'http://f0609136.xsph.ru/src/callback.php',
        ];

        /**
         * Нам необходимо инициировать запрос к серверу.
         * Воспользуемся библиотекой cURL.
         */
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        /** Теперь мы можем обработать ответ, полученный от сервера */
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
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        /**
         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
         * нам придётся перевести ответ в формат, понятный PHP
         */
        $response = json_decode($out, true);
        self::saveToken($response);
    }
}
