<?php
/**
 *
 * Class User - Пользователь
 *
 */

class UsersPhotos
{
    public $username;
    public $uid;
    public $nextMaxId;
    public $photos;
    public $photosCount = 0;

    public function __construct($username, $uid)
    {
        $this->username = $username;
        $this->uid = $uid;
        $this->photos = array();
    }

    public function addPhoto(Photo $photo)
    {
        $this->photos[] = $photo;
        $this->photosCount++;
    }

    public function setNextMaxId($nextMaxId)
    {
        $this->nextMaxId = $nextMaxId;
    }

    public function getPhotosCount()
    {
        return $this->photosCount;
    }
}