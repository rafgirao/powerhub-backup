<?php


namespace App\Traits;

use App\Scopes\AccountScope;


trait AccountTrait
{
    /**
     *
     */
    public static function booted()
    {
        static::addGlobalScope(new AccountScope);
    }
}
