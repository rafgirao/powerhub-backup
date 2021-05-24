<?php

namespace App\Models;

use Creativeorange\Gravatar\Exceptions\InvalidEmailException;
use Creativeorange\Gravatar\Gravatar;
use Grosv\LaravelPasswordlessLogin\PasswordlessLogin;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Concerns\IsFilamentUser;
use Filament\Models\Contracts\FilamentUser;


class User extends Authenticatable implements FilamentUser
{
    use Notifiable, IsFilamentUser;

//    protected $appends = ['login', 'linkLogin'];

//    public static $filamentUserColumn = 'is_filament_user';
//    public static $filamentRolesColumn = 'filament_roles'; // The name of a JSON column in your database.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'picture',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

//    public function isFilamentAdmin()
//    {
//        return $this->email === 'rgiraon@gmail.com';
//    }

    /**
     * Get the role of the user
     *
     * @return BelongsTo
     */
    public function getRole(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    function getLoginAttribute(): string
    {
        return 'Login';
    }

    function getLinkLoginAttribute(): string
    {
        return PasswordlessLogin::forUser($this)->generate();
    }

    /**
     * Get the path to the profile picture
     *
     * @return string
     * @throws InvalidEmailException
     */
    public function profilePicture(): string
    {
        if ($this->picture) {
            return Storage::url($this->picture);
        }
        return (new Gravatar())->get($this->email ?? 'example@gmail.com');
    }

    /**
     * Check if the user has admin role
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    /**
     * Check if the user has creator role
     *
     * @return boolean
     */
    public function isCreator()
    {
        return $this->role_id == 2;
    }

    /**
     * Check if the user has user role
     *
     * @return boolean
     */
    public function isMember()
    {
        return $this->role_id == 3;
    }

    /**
     * @return BelongsToMany
     */
    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, 'user_account', 'user', 'account');
    }

    /**
     * @return HasMany
     */
    public function getUserAccount(): HasMany
    {
        return $this->hasMany(UserAccount::class, 'user', 'id');
    }
}
