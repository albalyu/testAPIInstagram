<?php
/**
 *
 * Class Photo - Данные фотографий
 *
 */

class Photo
{
    public $id;
    public $created_time;
    public $images;
    public $caption;
    public $comments;
    public $likes;

    public function __construct($mediaObject)
    {
        $this->id = $mediaObject->id;
        $this->created_time = $mediaObject->created_time;
        $this->images = new Images($mediaObject->images);
        $this->caption = $mediaObject->caption->text;
        $this->comments = $mediaObject->comments->count;
        $this->likes = $mediaObject->likes->count;
    }
}