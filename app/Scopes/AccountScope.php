<?php

namespace App\Scopes;

use App\Services\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AccountScope implements Scope
{
    protected $act;

    public function __construct($act = null)
    {
        $this->act = $act;
    }

    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check() === true) {
            (new Helper)->getAccountInfo();
            $builder->where('account', session()->get('account')->id);
        }
    }
}
