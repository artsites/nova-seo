<?php

namespace App\Rules;

namespace ArtSites\NovaSeo\Rules;

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

        if(strlen($data?->title ?? '') > 191) {
            $this->message = 'Максимальная длина поля "Title" - 191 символ';
            return false;
        }

        if(strlen($data?->description ?? '') > 5000) {
            $this->message = 'Максимальная длина поля "Description" - 5000 символов';
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }
}
