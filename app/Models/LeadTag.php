<?php

namespace App\Models;

use App\Services\ActiveCampaign;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadTag extends Pivot
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'lead_tag';

    /**
     * @var string[]
     */
    protected $fillable = [
        'account',
        'lead',
        'tag',
        'provider_created_at',
        'provider_updated_at'
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
    public function getLead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function getTag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag', 'id');
    }

    protected function getAcLeads($act, $datePreset, $dateType): iterable
    {
        $response = (new Lead)->getAcLeads($act, $datePreset, $dateType, 1);
        $total = $response->meta->total ?? 0;

        for ($offset = 0; $offset < $total; $offset = $offset + 100) {
            $leads = (new Lead)->getAcLeads($act, $datePreset, $dateType, 100, $offset, 1)->contacts;
            foreach ($leads as $lead) {
                yield $lead;
            }
        }
    }

    public function getAcLeadTags($act, $lead): iterable
    {
        $acLeadTags = (new ActiveCampaign)->getAcContactTagsByLeadId($act, $lead);

        foreach ($acLeadTags as $acLeadTag) {
            yield $acLeadTag;
        }
    }

    public function prepareAcLeadTag($act, $datePreset, $dateType)
    {
        $integration = Integration::where('account', $act)->where('provider_name', 'Active Campaign')->first();

        $acLeads = $this->getAcLeads($act, $datePreset, $dateType);

        foreach ($acLeads as $acLead) {
            $acLeadTags = $this->getAcLeadTags($act, $acLead->id);
            foreach ($acLeadTags as $acLeadTag) {

                $lead = (isset($acLead->email)
                    ? (Lead::where('account', $act)->whereEmail($acLead->email)->first() ?? Lead::acLeadsUpdateOrCreate($act, $acLead))
                    : Lead::acLeadsUpdateOrCreate($act, $acLead));


                $tag = (isset($acLeadTag->tag)
                    ? (Tag::where('account', $act)->where('integration', $integration->id)->where('provider_tag_id', $acLeadTag->tag)->first() ?? Tag::acTagsUpdateOrCreate($act, $acLeadTag, 'Active Campaign'))
                    : Tag::acTagsUpdateOrCreate($act, $acLeadTag, 'Active Campaign'));

                $this->leadTagUpdateOrCreate($act, $lead, $tag, $acLeadTag);
            }
        }

    }

    protected function leadTagUpdateOrCreate($act, $lead, $tag, $acLeadTag)
    {
        return self::updateOrCreate(
            [
                'account' => $act,
                'lead' => $lead->id,
                'tag' => $tag->id
            ],
            [
                'provider_created_at' => $acLeadTag->created_timestamp ?? null,
                'provider_updated_at' => $acLeadTag->updated_timestamp  ?? null,
            ]
        );
    }
}
