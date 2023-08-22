<?php

namespace Artsites\NovaSeo\Rules;

use Illuminate\Contracts\Validation\Rule;

class SeoLinkRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return !str_contains($value, '?');
    }

    public function message()
    {
        return 'Посадочная страница не может содержать get-параметры.';
    }
}
