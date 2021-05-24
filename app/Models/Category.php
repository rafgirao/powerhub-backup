<?php

namespace App\Models;

use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Category extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    protected $fillable = ['name', 'description'];

    public function account()
    {
        return $this->belongsTo(Account::class,'account', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
