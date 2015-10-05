<?php
/**
 *
 * Class Images - Изображения фотографий
 *
 */

class Images
{
    public $low;
    public $thumbnail;
    public $standard;

    public function __construct($images)
    {
        $this->low = $images->low_resolution->url;
        $this->thumbnail = $images->thumbnail->url;
        $this->standard = $images->standard_resolution->url;
    }
}