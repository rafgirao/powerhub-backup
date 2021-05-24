<?php

namespace App\Models;

use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class IntegrationDet extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    protected $table = 'integrations_det';

    protected $fillable = [
        'id',
        'account',
        'integration',
        'key',
        'value',
        'description',
        'timezone',
        'currency',
        'status',
        'expires_in',
        'created_at',
        'updated_at',
    ];

    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class,'account', 'id');
    }

    public function getInsights(): HasMany
    {
        return $this->hasMany(Insight::class, 'integration_det', 'id')->with('getIntegrationDet');
    }

    public function getCampaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'integration_det', 'id')->with('getIntegrationDet');
    }
}
