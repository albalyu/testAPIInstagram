<?php

include_once"inc/class.Answer.php";
include_once"inc/class.Curl.php";
include_once"inc/class.DAO.php";
include_once"inc/class.Images.php";
include_once"inc/class.Model.php";
include_once"inc/class.Photo.php";
include_once"inc/class.PhotosData.php";
include_once"inc/class.User.php";
include_once"inc/class.UsersPhotos.php";

// Actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'get_users':
            $answer = Model::getUsersData();
            break;

        case 'get_users_photos':
            $answer = Model::getUsersPhotos();
            break;

        case 'get_photos_data':
            $answer = Model::getPhotosData();
            break;

        default:
            $data = Answer::error('Action not found');
            $answer = $data->encode();
            break;
    }
} else {
    $data = Answer::error('Action not found');
    $answer = $data->encode();
}

echo $answer;