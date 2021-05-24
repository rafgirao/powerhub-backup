<?php

namespace App\Rules;

use App\Services\Helper;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class YoutubeUrlCheckRule
 * @package App\Rules
 */
class YoutubeUrlCheckRule implements Rule
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
        if (Helper::UrlChecker($value, 'youtube.com') === true or Helper::UrlChecker($value, 'youtu.be') === true){
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
        return 'A URL do Youtube não é válida.';
    }
}
