<?php
/**
 *
 * Class User - Пользователь
 *
 */

class User
{
    public $username;
    public $profile_picture;
    public $id;
    public $full_name;

    public function __construct($userData)
    {
        $this->username = $userData->username;
        $this->profile_picture = $userData->profile_picture;
        $this->id = $userData->id;
        $this->full_name = $userData->full_name;
    }
}