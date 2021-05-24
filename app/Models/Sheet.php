<?php

namespace App\Models;

use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Sheet extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'sheets';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'account',
        'sheet_id',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return MorphMany
     */
    public function getProjectDetByKey(): MorphMany
    {
        return $this->morphMany(ProjectDet::class, 'key');
    }


}
