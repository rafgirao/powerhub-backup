<?php

namespace App\Models;

use App\Services\ActiveCampaign;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class EmailCampaign extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    protected $table = 'email_campaigns';

    protected $fillable = [
        'account',
        'integration',
        'provider_email_campaign_id',
        'campaign_name',
        'type',
        'campaign_subject',
        'last_sent_date',
        'sends',
        'opens',
        'unique_opens',
        'clicks',
        'unique_clicks',
        'forwards',
        'unique_forwards',
        'unsubscribes',
        'bounces',
//        'open_rate',
//        'click_to_open_rate',
//        'click_rate',
//        'forward_rate',
//        'unsubscribe_rate',
//        'bounce_rate',
        'screenshot',
        'status',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class,'account', 'id');
    }

    public function integration()
    {
        return $this->belongsTo(Integration::class,'account', 'id');
    }

    public function projectDet()
    {
        return $this->morphMany(ProjectDet::class, 'key');
    }

    public function acEmailCampaigns($act, $source)
    {
        $campaigns = (new ActiveCampaign)->getAllCampaigns($act);

        if (isset($campaigns)){
            foreach ($campaigns as $campaign){
                $this->acEmailCampaignsUpdateOrCreate($act, $campaign, $source);
            };
        }
    }

    private function acEmailCampaignsUpdateOrCreate($act, $campaign, $source)
    {
        return self::updateOrCreate(
            [
                'account' => $act,
                'integration' => Integration::where('account', $act)->where('provider_name', $source)->first()->id,
                'provider_email_campaign_id' => $campaign->id
            ],
            [
                'type' => $campaign->type,
                'campaign_name' => $campaign->name,
//                'campaign_subject' => $campaign->campaign_subject,
                'last_sent_date' => $campaign->sdate,
                'sends' => $campaign->send_amt,
                'opens' => $campaign->opens,
                'unique_opens' => $campaign->uniqueopens,
                'clicks' => $campaign->linkclicks,
                'unique_clicks' => $campaign->uniquelinkclicks,
                'forwards' => $campaign->forwards,
                'unique_forwards' => $campaign->uniqueforwards,
                'unsubscribes' => $campaign->unsubscribes,
                'bounces' => $campaign->hardbounces + $campaign->softbounces,
//                'open_rate' => $campaign->open_rate,
//                'click_to_open_rate' => $campaign->click_to_open_rate,
//                'click_rate' => $campaign->click_rate,
//                'forward_rate' => $campaign->forward_rate,
//                'unsubscribe_rate' => $campaign->unsubscribe_rate,
//                'bounce_rate' => $campaign->bounce_rate,
                'screenshot' => $campaign->screenshot,
                'status' => 1,

            ]
        );
    }

    public function getTypeAttribute($value)
    {
        if ($value === 'single'){
            return 'Padrão';
        } elseif ($value === 'split'){
            return 'Teste A/B';
        } else {
            return 'Outros';
        }
    }

    public function getLastSentDateAttribute($date)
    {
        $date=date_create($date);
        return date_format($date,"d/m/Y");
    }

//    public function getScreenshotAttribute($value)
//    {
//        return "https://{$value}";
//    }

}
