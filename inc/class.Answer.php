<?php
/**
 *
 * Class Answer - Класс ответов
 *
 */

class Answer
{
    public $state;
    public $msg;
    public $count;
    public $data;

    /**
     * @param object $data - объект с данными ответа
     * @param string $state - статус результата
     * @param string $msg - строка с текстом сообщения
     */
    private function __construct($data, $state, $msg = '')
    {
        $this->state = $state;

        if ($state != 'good') {
            unset($this->count);
            unset($this->data);
        } else {
            $this->data = $data;
            $this->count = count($data);
        }

        if ($msg != '') {
            $this->msg = $msg;
        } else {
            unset($this->msg);
        }
    }

    /**
     * Метод генерирует объект сообщения с ошибкой
     *
     * @param $msg - Текст сообщения
     * @return Answer - объект сообщения
     */
    public static function error($msg)
    {
        return new Answer(null, 'error', $msg);
    }

    /**
     * Метод генерирует объект сообщения без ошибки
     *
     * @param $data - объект с данными ответа
     * @return Answer - объект сообщения
     */
    public static function good($data)
    {
        return new Answer($data, 'good');
    }

    /**
     * Метод преобразует объект сообщения в json
     *
     * @return string - json
     */
    public function encode()
    {
        return json_encode($this);
    }
}