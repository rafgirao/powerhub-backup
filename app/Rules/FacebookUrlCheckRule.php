<?php

namespace App\Rules;

use App\Services\Helper;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class FacebookUrlCheckRule
 * @package App\Rules
 */
class FacebookUrlCheckRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Helper::UrlChecker($value, 'facebook.com') === true or Helper::UrlChecker($value, 'fb.be') === true){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A URL do Facebook não é válida.';
    }
}
