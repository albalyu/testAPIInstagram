<?php
/**
 *
 * Class DAO - Data Access Object
 *
 */
class DAO
{
    /**
     * Метод получает USER_ID по логину пользователя
     *
     * @param string $login - логин искомого пользователя
     * @return string - USER_ID (если пользователя с таким логином не существует, возвращается false)
     */
    public static function getUserid($login)
    {
        return Curl::getUserid($login);
    }

    /**
     * Метод получает данные пользователя по его USER_ID
     *
     * @param int $uid - USER_ID
     * @return object - Данные пользователя
     */
    public static function getUser($uid)
    {
        return Curl::getUser($uid);
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
        return Curl::getMedia($uid, $nextMaxId);
    }

    /**
     * Метод получает лайки медиаобъекта
     *
     * @param int $mediaId - id медиаобъекта
     * @return object - Объект с лайками
     */
    public static function getLikes($mediaId)
    {
        return Curl::getLikes($mediaId);
    }

    /**
     * Метод получает комментарии медиаобъекта
     *
     * @param int $mediaId - id медиаобъекта
     * @return object - Объект с комментариями
     */
    public static function getComments($mediaId)
    {
        return Curl::getComments($mediaId);
    }

    /**
     * Метод получает данные медиаобъекта
     *
     * @param int $mediaId - id медиаобъекта
     * @return object - Объект с данными медиаобъекта
     */
    public static function getPhotosData($mediaId)
    {
        return Curl::getPhotosData($mediaId);
    }
}