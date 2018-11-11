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

    //todo ambigous. U be more minimal. U can use if (!getErrors())
    public function isErrorEmpty()
    {
        return empty($this->error);
    }

    public function clean($field)
    {
        return strip_tags($field);
    }

    //todo no. SOLID - Single resposibility - do only one thing - check empty or clean
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
        $allowedMimes = [
            'image/gif',
            'image/jpeg',
            'image/jpg',
            'image/png',
        ];
        if (!in_array($filesImage['type'], $allowedMimes, true) || $filesImage['size'] <= 0) {
            $this->addError('Изображение должно иметь формат GIF, JPEG, или PNG');
        }
        if ($filesImage['error'] !== 0) {
            $this->addError('Проблема с загрузкой файла');
        }
//        //todo 1 - u dont need all these brackets
//        //todo 2 - i see an error here in !A || !B || !C || !D -- u got an error even if image not an image/give  and size <= 0
//        if (
//            (
//                $filesImage['type'] !== 'image/gif'
//                || $filesImage['type'] !== 'image/jpeg'
//                || $filesImage['type'] !== 'image/jpg'
//                || $filesImage['type'] !== 'image/png'
//            )
//            && $filesImage['size'] <= 0
//        ) {
//            $this->addError('Изображение должно иметь формат GIF, JPEG, или PNG');
//        }
    }
    //  todo ambiguous. just iterate array with errors in view
    public function getHtmlMessage()
    {
        foreach ($this->getError() as $error) {
            $this->message .= $error . '<br>';
        }
        return $this->message;

    }
}