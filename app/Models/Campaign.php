<?php

namespace App\Models;

use App\Services\Facebook;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Campaign extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    protected $table = 'campaigns';

    protected $fillable = [
        'account',
        'integration_det',
        'provider_campaign_id',
        'provider_campaign_name',
        'buying_type',
        'objective',
        'status',
        'bid_strategy',
        'daily_budget',
        'lifetime_budget',
        'start_time',
        'stop_time',
    ];

    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class,'account', 'id');
    }

    public function getProjectDetByKey(): MorphMany
    {
        return $this->morphMany(ProjectDet::class, 'key');
    }

    public function getCampaignsInsight(): HasMany
    {
        return $this->hasMany(CampaignInsight::class, 'campaign', 'id');
    }

    public function getIntegrationDet(): BelongsTo
    {
        return $this->belongsTo(IntegrationDet::class,'integration_det', 'id');
    }

    public function listFbAdAccounts($act)
    {
        $fbCredentials = (new Integration)->fbCredentials($act);

        if (!empty($fbCredentials->fbAdAccounts)){
            foreach ($fbCredentials->fbAdAccounts as $fbCredential) {

                if ($fbCredential->status == 1) {
                    $this->fbCampaigns($act, $fbCredential->value, $fbCredentials->fbToken);
                }
            }
        }
    }

    public function fbCampaigns($act, $fbAdAccount, $fbToken)
    {
        $integrationDet = IntegrationDet::where('account', $act)->where('value', $fbAdAccount)->first()->id;
        $total = 25;
        $after = null;

        while ($total >= 25){
            $campaigns = $this->getFbCampaigns($fbAdAccount, $fbToken, null, $after);
            $total = isset($campaigns->data) ? count($campaigns->data) : 0;

            $after = (isset($campaigns->paging) ?
                (isset($campaigns->paging->cursors) ?
                    ($campaigns->paging->cursors->after ?? null) :
                    null)
                : null);

            if (isset($campaigns->data)){
                foreach ($campaigns->data as $campaign) {
                    $this->fbCampaignsUpdateOrCreate($act, $integrationDet, $campaign);
                }
            }
        }
    }

    public function getFbCampaigns($fbAdAccount, $fbToken, $before, $after)
    {
        $fields = 'id,name,buying_type,objective,status,bid_strategy,daily_budget,lifetime_budget,start_time,stop_time';
        return (new Facebook)->getFbCampaigns($fbAdAccount, $fbToken, $fields, null, $before, $after);
    }

    public function fbCampaignsUpdateOrCreate($act, $integrationDet, $campaign)
    {
        return $this->updateOrCreate(
            [
                'account' => $act,
                'integration_det' => $integrationDet,
                'provider_campaign_id' => ($campaign->id ?? $campaign->campaign_id),
            ],
            [
                'provider_campaign_name' => str_replace(array("\n\r", "\n", "\r", PHP_EOL),' ',($campaign->name ?? $campaign->campaign_name)),
                'buying_type' => ($campaign->buying_type ?? null),
                'objective' => ($campaign->objective ?? null),
                'status' => ($campaign->status ?? null),
                'bid_strategy' => ($campaign->bid_strategy ?? null),
                'daily_budget' => ($campaign->daily_budget ?? null),
                'lifetime_budget' => ($campaign->lifetime_budget ?? null),
                'start_time' => ($campaign->start_time ?? null),
                'stop_time' => ($campaign->stop_time ?? null),
            ]
        );

    }
}

