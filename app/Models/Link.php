<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Link extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    protected $appends = [
        'deeplink',
        'project_name'
    ];

    protected $table = 'links';

    protected $fillable = [
        'id',
        'account',
        'project',
        'url',
        'short_link',
        'clicks'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    public function getProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project', 'id');
    }

    public function getDeeplinkAttribute()
    {
        return env('APP_URL').'/go/'.$this->short_link;
    }

    public function getProjectNameAttribute()
    {
        return $this->getProject->name;
    }

}
