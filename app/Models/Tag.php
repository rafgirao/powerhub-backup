<?php

namespace App\Models;

use App\Services\ActiveCampaign;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Tag extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'account',
        'integration',
        'provider_tag_id',
        'name',
        'color',
        'tag_type',
        'description',
        'subscriber_count',
    ];

    /**
     * @return BelongsTo
     */
    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function getIntegration(): BelongsTo
    {
        return $this->belongsTo(Integration::class, 'account', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function getLeads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'lead_tag', 'tag', 'lead');
    }

    /**
     * @return MorphMany
     */
    public function getProjectDetByKey(): MorphMany
    {
        return $this->morphMany(ProjectDet::class, 'key');
    }

    /**
     * @param $act
     * @param $source
     */
    public function acTags($act, $source)
    {
        $tags = (new ActiveCampaign)->getAcTags($act);

        if (isset($tags)) {
            foreach ($tags as $tag) {
                $this->acTagsUpdateOrCreate($act, $tag, $source);
            };
        }
    }

    /**
     * @param $act
     * @param $tag
     * @param $source
     * @return Model|Tag
     */
    protected function acTagsUpdateOrCreate($act, $tag, $source)
    {
        return self::updateOrCreate(
            [
                'account' => $act,
                'integration' => Integration::where('account', $act)->where('provider_name', $source)->first()->id,
                'provider_tag_id' => $tag->id
            ],
            [
                'name' => $tag->tag ?? 'UNDEFINED',
                'description' => $tag->description ?? null,
                'tag_type' => $tag->tagType ?? null,
                'subscriber_count' => $tag->subscriber_count ?? null,
            ]
        );
    }
}
