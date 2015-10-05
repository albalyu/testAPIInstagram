<?php
/**
 *
 * Class Model - Модель данных
 *
 */
class Model
{
    private static $maxPhotosCount = 100; // Максимальное (дефолтное) количество загружаемых фотографий

    /**
     * Метод получает массив с USER_ID пользователей
     *
     * @param string $usernamesStr - строка с логинами
     * @return array[string] - массив с USER_ID искомых пользователей
     */
    private static function getUsers($usernamesStr)
    {
        $usernames = explode(',', $usernamesStr);
        $uids = array();

        foreach ($usernames as $username) {
            $uid = DAO::getUserid($username);

            if ($uid) {
                $uids[$username] = $uid;
            }
        }

        return $uids;
    }

    /**
     * Метод получает общие данные пользователей
     *
     * @param string $usernamesStr - строка с логинами
     * @return string - json (данные пользователей)
     */
    public static function getUsersData()
    {
        $uids = self::getUsers($_GET['account']);
        $users = array();

        foreach ($uids as $uid) {
            $users[] = DAO::getUser($uid);
        }

        if (count($users) > 0 && $users[0] != null) {
            $answer = Answer::good($users);
        } else {
            $msg = 'Users not found';
            $answer = Answer::error($msg);
        }

        return $answer->encode();
    }

    /**
     * Метод получает MaxId следующего запроса
     *
     * @param object $media - Медиаобъект
     * @return null/int - next_max_id - MaxId следующего запроса (если есть)
     */
    private static function getNextMaxId($media)
    {
        if (isset($media->pagination) && isset($media->pagination->next_max_id)) {
            $nextMaxId = $media->pagination->next_max_id;
        } else {
            $nextMaxId = null;
        }

        return $nextMaxId;
    }

    /**
     * Метод возвращает данные фотографий пользователя
     *
     * @return string - json с данными фотографий пользователя
     */
    public static function getUsersPhotos()
    {
        $uids = self::getUsers($_GET['account']);
        $uidsCount = count($uids);

        if ($uidsCount == 1) {
            // Количество загружаемых фотографий
            $photosCount = isset($_GET['count']) ? $_GET['count'] : Model::$maxPhotosCount;
            $photosCount = $photosCount <= 0 || $photosCount > Model::$maxPhotosCount ? Model::$maxPhotosCount : $photosCount;

            // MaxId запроса
            $nextMaxId = isset($_GET['next_max_id']) ? $_GET['next_max_id'] : false;

            foreach ($uids as $username => $uid) {
                $user = new UsersPhotos($username, $uid);

                // Пока не загрузили нужнгое количество фото
                while ($user->getPhotosCount() < $photosCount && $nextMaxId !== null) {
                    // Загружаем очередную порцию медиаобъектов (Instagram позволяет не более 20-ти)
                    $media = DAO::getMedia($uid, $nextMaxId);
                    $nextMaxId = self::getNextMaxId($media);
                    $user->setNextMaxId($nextMaxId);

                    // Проходим по загруженным медиаобъектам и выбираем фотографии
                    foreach ($media->data as $mediaObject) {
                        if ($mediaObject->type == 'image') {
                            $user->addPhoto(new Photo($mediaObject));
                        }
                    }
                }

                if ($user->getPhotosCount() > 0) {
                    $answer = Answer::good($user);
                } else {
                    $answer = Answer::error('Photos not found');
                }

                break;
            }
        }

        else if ($uidsCount > 1) {
            $answer = Answer::error('Not multiples users');
        }

        else {
            $answer = Answer::error('User not found');
        }

        // Возвращаем фотографии пользователя
        return $answer->encode();
    }

    /**
     * Метод возвращает json с данными отдельной фотографии
     *
     * @return string - json с данными отдельной фотографии
     */
    public static function getPhotosData()
    {
        // Общие данные фотографии
        $photosData = DAO::getPhotosData($_GET['media_id']);

        // Ошибка
        if ($photosData->meta->code == 400) {
            $answer = Answer::error($photosData->meta->error_message);
        }

        // Нет ошибки
        else {
            $comments = DAO::getComments($_GET['media_id']);
            $likes = DAO::getLikes($_GET['media_id']);

            $photo = new PhotosData($photosData->data, $comments->data, $likes->data);
            $answer = Answer::good($photo);
        }

        return $answer->encode();
    }
}