<?php

namespace Artsites\NovaSeo\Rules;

use Illuminate\Contracts\Validation\Rule;

class NovaSeoRule implements Rule
{
    private string $message;

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $data = json_decode($value);

        if(mb_strlen($data?->title ?? '') > 191) {
            $this->message = 'Максимальная длина поля "Title" - 191 символ';
            return false;
        }

        if(mb_strlen($data?->description ?? '') > 500) {
            $this->message = 'Максимальная длина поля "Description" - 500 символов';
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }
}
