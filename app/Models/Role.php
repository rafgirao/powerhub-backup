<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Get the users for the role
     *
     * @return HasMany
     */
    public function getUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
