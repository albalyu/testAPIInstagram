<?php
/**
 *
 * Class PhotosData - Полные данные фотографии
 *
 */

class PhotosData
{
    public $id;
    public $created;
    public $images;
    public $caption;
    public $user;
    public $comments;
    public $comments_dates;
    public $likes;

    public function __construct($photosData, $comments, $likes)
    {
        $this->id = $photosData->id;
        $this->created = $photosData->created_time;
        $this->images = new Images($photosData->images);
        $this->caption = $photosData->caption->text;
        $this->user = new User($photosData->user);

        $this->setComments($comments);
        $this->setLikes($likes);
    }

    /**
     * Метод добавляет комментарии объекту
     *
     * @param array $comments - массив комментариев
     */
    private function setComments($comments)
    {
        $this->comments = array();
        $this->comments_dates = array();
        foreach ($comments as $comment) {
            $this->comments[] = $comment;
            $this->addCommentsDate($comment->created_time);
        }
    }


    /**
     * Метод добавляет лайки объекту
     *
     * @param array $likes - массив лайков
     */
    private function setLikes($likes)
    {
        $this->likes = array();
        foreach ($likes as $user) {
            $this->likes[] = $user;
        }
    }

    /**
     * Метод распределяет комментарии по датам
     *
     * @param int $commentsDate - timestamp комментария
     */
    private function addCommentsDate($commentsDate)
    {
        $day = date('d', $commentsDate);
        $month = date('m', $commentsDate);
        $year = date('Y', $commentsDate);

        if (!isset($this->comments_dates[$year])) {
            $this->comments_dates[$year] = array();
        }
        if (!isset($this->comments_dates[$year][$month])) {
            $this->comments_dates[$year][$month] = array();
        }
        if (isset($this->comments_dates[$year][$month][$day])) {
            $this->comments_dates[$year][$month][$day]++;
        } else {
            $this->comments_dates[$year][$month][$day] = 1;
        }
    }
}