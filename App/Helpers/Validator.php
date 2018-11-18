<?php
namespace App\Helpers;

class Validator
{
    private $error = [];

    public function addError($error)
    {
        $this->error[] = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function clean($field)
    {
        return strip_tags($field);
    }

    public function checkEmpty($field, $error)
    {
        if (empty($field)) {
            $this->addError($error);
        }
        return $field;
    }

    public function isDigit($value)
    {
        return ctype_digit($value);
    }

    public function isAlpha($value)
    {
        return ctype_alpha($value);
    }

    public function confirmPassword($password1, $password2, $error)
    {
        if ($password1 !== $password2) {
            $this->addError($error);
        }
    }

    public function checkImage($filesImage)
    {
        //todo clear ambiguous here
        $filesImageName = $this->clean($filesImage['name']);
        $this->checkEmpty($filesImageName, 'Выберите изображение для статьи');

        $allowedMimes = [
            'image/gif',
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];
        if (!in_array($filesImage['type'], $allowedMimes, true) || $filesImage['size'] <= 0) {
            $this->addError('Изображение должно иметь формат GIF, JPEG, или PNG');
        }

        if ($filesImage['error'] !== 0) {
            $this->addError('Проблема с загрузкой файла');
        }
    }
}
