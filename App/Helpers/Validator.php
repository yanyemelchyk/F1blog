<?php
namespace App\Helpers;

class Validator
{
    private $error;
    private $message;

    public function addError($error)
    {
        $this->error[] = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function isErrorEmpty()
    {
        return empty($this->error);
    }

    public function clean($field)
    {
        return strip_tags($field);
    }

    public function cleanAndCheckEmpty($field, $error)
    {
        $cleanField = $this->clean($field);
        if (empty($cleanField)) {
            $this->addError($error);
        }
        return $cleanField;
    }

    public function confirmPassword($password1, $password2, $error)
    {
        if ($password1 !== $password2) {
            $this->addError($error);
        }
    }

    public function checkImage($filesImage)
    {
        $this->cleanAndCheckEmpty($filesImage['name'], 'Выберите изображение для статьи');

        if ((($filesImage['type'] !== 'image/gif') || ($filesImage['type'] !== 'image/jpeg') || ($filesImage['type'] !== 'image/jpg') || ($filesImage['type'] !== 'image/png')) && ($filesImage['size'] <= 0)) {
            $this->addError('Изображение должно иметь формат GIF, JPEG, или PNG');
        }
        if ($filesImage['error'] !== 0) {
            $this->addError('Проблема с загрузкой файла');
        }
    }

    public function getMessage()
    {
        foreach ($this->getError() as $error) {
        $this->message .= $error . '<br>';
        }
        return $this->message;

    }
}