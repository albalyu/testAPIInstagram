<?php
/**
 *
 * Class Curl - cURL-запросы
 *
 */
class Curl
{
    private static $CLIENT_ID = 'e92d073f106648bba84341cc38f569a2';

    /**
     * Метод делает cURL запрос
     *
     * @param string $query - текст запроса
     * @return mixed - результат запроса
     */
    private static function curlExec($query)
    {
        $ch = curl_init($query);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Таймаут 15 секунд
        curl_setopt($ch, CURLOPT_HEADER, false);// Не выводить заголовки
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// Возвращать результат, а не выводить его прямо в браузер
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Метод получает USER_ID по логину пользователя
     *
     * @param string $login - логин искомого пользователя
     * @return string - USER_ID (если пользователя с таким логином не существует, возвращается false)
     */
    public static function getUserid($login)
    {
        $query = 'https://api.instagram.com/v1/users/search?q='.$login.'&client_id='.self::$CLIENT_ID;
        $result = self::curlExec($query);
        $uid = false;

        foreach ($result->data as $usersData) {
            if ($usersData->username == $login) {
                $uid = $usersData->id;
                break;
            }
        }

        return $uid;
    }

    /**
     * Метод получает данные пользователя по его USER_ID
     *
     * @param int $uid - USER_ID
     * @return object - Данные пользователя
     */
    public static function getUser($uid)
    {
        $query = 'https://api.instagram.com/v1/users/'.$uid.'/?client_id='.self::$CLIENT_ID;

        return self::curlExec($query);
    }

    /**
     * Метод получает медиаданные пользователя по его USER_ID и $nextMaxId
     *
     * @param int $uid - USER_ID
     * @param int/bool $nextMaxId - MaxId фото для следующего запроса
     * @return object - Медиаданные пользователя
     */
    public static function getMedia($uid, $nextMaxId)
    {
        if ($nextMaxId) {
            $query = 'https://api.instagram.com/v1/users/'.$uid.'/media/recent/?max_id='.$nextMaxId.'&client_id='.self::$CLIENT_ID;
        } else {
            $query = 'https://api.instagram.com/v1/users/'.$uid.'/media/recent/?client_id='.self::$CLIENT_ID;
        }

        return self::curlExec($query);
    }

    /**
     * Метод получает лайки медиаобъекта
     *
     * @param int $mediaId - id медиаобъекта
     * @return object - Объект с лайками
     */
    public static function getLikes($mediaId)
    {
        $query = 'https://api.instagram.com/v1/media/'.$mediaId.'/likes?client_id='.self::$CLIENT_ID;

        return self::curlExec($query);
    }

    /**
     * Метод получает комментарии медиаобъекта
     *
     * @param int $mediaId - id медиаобъекта
     * @return object - Объект с комментариями
     */
    public static function getComments($mediaId)
    {
        $query = 'https://api.instagram.com/v1/media/'.$mediaId.'/comments?client_id='.self::$CLIENT_ID;

        return self::curlExec($query);
    }

    /**
     * Метод получает данные медиаобъекта
     *
     * @param int $mediaId - id медиаобъекта
     * @return object - Объект с данными медиаобъекта
     */
    public static function getPhotosData($mediaId)
    {
        $query = 'https://api.instagram.com/v1/media/'.$mediaId.'?client_id='.self::$CLIENT_ID;

        return self::curlExec($query);
    }
}