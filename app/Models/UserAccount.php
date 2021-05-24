<?php

namespace App\Models;

use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class UserAccount extends Pivot
{
    use Notifiable, HasRoles, HasFactory;

    /**
     * @var string
     */
    protected $table = 'user_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user',
        'account'
    ];

    public function getUser(): BelongsTo
    {
        return $this->belongsTo(User::class,'user', 'id');
    }

    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class,'account', 'id');
    }
}
