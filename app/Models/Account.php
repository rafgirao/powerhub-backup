<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Webpatser\Uuid\Uuid;


class Account extends Model
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company',
    ];

    /**
     *
     */
    public static function booted()
    {
        self::creating(function ($model){
            $model->uuid = Uuid::generate();
        });
    }

    /**
     * @return HasMany
     */
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function campaignInsights(): HasMany
    {
        return $this->hasMany(CampaignInsight::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function leadTags(): HasMany
    {
        return $this->hasMany(LeadTag::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function insights(): HasMany
    {
        return $this->hasMany(Insight::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function integrations(): HasMany
    {
        return $this->hasMany(Integration::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function integrationsDet(): HasMany
    {
        return $this->hasMany(IntegrationDet::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function projectsDet(): HasMany
    {
        return $this->hasMany(ProjectDet::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class,'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class,'link', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_account', 'account', 'user');
    }

    /**
     * @return HasMany
     */
    public function getUserAccount(): HasMany
    {
        return $this->hasMany(UserAccount::class, 'account', 'id');
    }
}
