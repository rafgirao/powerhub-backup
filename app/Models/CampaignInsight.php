<?php

namespace App\Models;

use App\Services\Facebook;
use App\Services\Helper;
use App\Traits\AccountTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class CampaignInsight extends Pivot
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'campaigns_insights';

    /**
     * @var string[]
     */
    protected $fillable = [
        'account',
        'campaign',
        'insight',
        'group',
        'value',
        'date',
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
    public function getInsight(): BelongsTo
    {
        return $this->belongsTo(Insight::class, 'insight', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function getCampaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign', 'id');
    }

    /**
     * @param $act
     * @param $currency
     * @param $startDate
     * @param $endDate
     * @param $fbCampaigns
     * @return mixed
     */
    public static function getTrafficSummaryFbCampaignsSum($act, $currency, $startDate, $endDate, $fbCampaigns)
    {
        return Campaign::withoutGlobalScopes()
            ->select('campaigns_insights.date', 'campaigns_insights.value')
            ->join('integrations_det', 'campaigns.integration_det', '=', 'integrations_det.id')
            ->join('campaigns_insights', 'campaigns.id', '=', 'campaigns_insights.campaign')
            ->join('insights', 'campaigns_insights.insight', '=', 'insights.id')
            ->where('integrations_det.account', $act)
            ->where('campaigns_insights.account', $act)
            ->whereIn('campaigns.id', $fbCampaigns)
            ->where('insights.provider_insight', 'spend')
            ->where('integrations_det.currency', $currency)
            ->whereBetween('campaigns_insights.date', [$startDate, $endDate])
            ->where('integrations_det.status', '=', 1)
            ->sum('campaigns_insights.value');
    }

    /**
     * @param $act
     * @param $currency
     * @param $startDate
     * @param $endDate
     * @param $fbCampaigns
     * @param $kpis
     * @return mixed
     */
    public static function getTrafficSummaryFbCampaignsDaily($act, $currency, $startDate, $endDate, $fbCampaigns, $kpis)
    {
        foreach ($kpis as $kpi) {
            $kpiId[] = $kpi->id ?? null;
        }

        $kpiId = array_unique($kpiId);

        return Campaign::withoutGlobalScopes()
            ->selectRaw('campaigns.id as campaign, campaigns_insights.date, insights.id, insights.name, sum(campaigns_insights.value) as value')
            ->join('integrations_det', 'campaigns.integration_det', '=', 'integrations_det.id')
            ->join('campaigns_insights', 'campaigns.id', '=', 'campaigns_insights.campaign')
            ->join('insights', 'campaigns_insights.insight', '=', 'insights.id')
            ->where('integrations_det.account', $act)
            ->where('campaigns_insights.account', $act)
            ->whereIn('campaigns.id', $fbCampaigns)
            ->whereIn('insights.id', $kpiId)
            ->whereIn('campaigns_insights.group', ['kpis', 'actions'])
            ->where('integrations_det.currency', $currency)
            ->whereBetween('campaigns_insights.date', [$startDate, $endDate])
            ->where('integrations_det.status', '=', 1)
            ->orderBy('date', 'ASC')
            ->groupBy('insights.id', 'campaigns_insights.date')
            ->get();
    }

    /**
     * @param $act
     * @param $currency
     * @param $startDate
     * @param $endDate
     * @param $fbCampaigns
     * @param $kpis
     * @return mixed
     */
    public static function getTrafficSummaryFbCampaigns($act, $currency, $startDate, $endDate, $fbCampaigns, $kpis)
    {
        foreach ($kpis as $kpi) {
            $kpiId[] = $kpi->id ?? null;
        }

        $kpiId = array_unique($kpiId);

        return Campaign::withoutGlobalScopes()
            ->selectRaw('campaigns.id as campaign, insights.id, insights.name, sum(campaigns_insights.value) as value')
            ->join('integrations_det', 'campaigns.integration_det', '=', 'integrations_det.id')
            ->join('campaigns_insights', 'campaigns.id', '=', 'campaigns_insights.campaign')
            ->join('insights', 'campaigns_insights.insight', '=', 'insights.id')
            ->where('integrations_det.account', $act)
            ->where('campaigns_insights.account', $act)
            ->whereIn('campaigns.id', $fbCampaigns)
            ->whereIn('insights.id', $kpiId)
            ->whereIn('campaigns_insights.group', ['kpis', 'actions'])
            ->where('integrations_det.currency', $currency)
            ->whereBetween('campaigns_insights.date', [$startDate, $endDate])
            ->where('integrations_det.status', '=', 1)
            ->groupBy('insights.id')
            ->get();
    }

    /**
     * @param $act
     * @param $currency
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public static function getTrafficSummarySum($act, $currency, $startDate, $endDate)
    {
        return Campaign::withoutGlobalScopes()
            ->select('campaigns_insights.date', 'campaigns_insights.value')
            ->join('integrations_det', 'campaigns.integration_det', '=', 'integrations_det.id')
            ->join('campaigns_insights', 'campaigns.id', '=', 'campaigns_insights.campaign')
            ->join('insights', 'campaigns_insights.insight', '=', 'insights.id')
            ->where('integrations_det.account', $act)
            ->where('campaigns_insights.account', $act)
            ->where('insights.provider_insight', 'spend')
            ->where('integrations_det.currency', $currency)
            ->whereBetween('campaigns_insights.date', [$startDate, $endDate])
            ->where('integrations_det.status', '=', 1)
            ->sum('campaigns_insights.value');
    }

    /**
     * @param $act
     * @param $datePreset
     */
    public function listFbAdAccounts($act, $datePreset)
    {
        $fbCredentials = (new Integration)->fbCredentials($act);

        if (!empty($fbCredentials->fbAdAccounts)) {
            foreach ($fbCredentials->fbAdAccounts as $fbCredential) {

                if ($fbCredential->status == 1) {
                    $this->fbCampaignInsights($act, $fbCredential->value, $fbCredentials->fbToken,
                        $datePreset);
                }
            }
        }
    }

    /**
     * @param $act
     * @param $fbAdAccount
     * @param $fbToken
     * @param $datePreset
     */
    public function fbCampaignInsights($act, $fbAdAccount, $fbToken, $datePreset)
    {
        $integrationDet = IntegrationDet::where('account', $act)->where('value', $fbAdAccount)->first();

        if ($datePreset === 'today' or $datePreset === 'yesterday') {
            $timeRanges = [null];
        } else {
            $timeRanges = $this->getTimeRange($datePreset);
            $datePreset = null;
        }

        foreach ($timeRanges as $timeRange) {

            $campaignsInsights = $this->getCampaignInsights(
                $fbAdAccount,
                $fbToken,
                $datePreset,
                1000,
                null,
                null,
                $timeRange);

            if (isset($campaignsInsights->data)) {
                foreach ($campaignsInsights->data as $campaignInsights) {
                    $this->prepareCampaignInsights($campaignInsights, $integrationDet);
                }
            }
        }
    }

    /**
     * @param $datePreset
     * @return iterable
     */
    protected function getTimeRange($datePreset): iterable
    {
        for ($week = $datePreset / 7; $week >= 1; $week--) {
            yield '{"since":"' . Carbon::now()->subWeeks($datePreset / 7 - $week + 1)->subDay()->toDateString() . '","until":"' . Carbon::now()->subWeeks($datePreset / 7 - $week)->toDateString() . '"}';
        }

    }

    /**
     * @param $campaignInsights
     * @param $integrationDet
     */
    protected function prepareCampaignInsights($campaignInsights, $integrationDet): void
    {
        $act = $integrationDet->account;
        $integrationDetId = $integrationDet->id;

        foreach ($campaignInsights as $key => $campaignInsightsDet) {

            $campaign = Campaign::where('account', $act)
                    ->where('provider_campaign_id', $campaignInsights->campaign_id)->first()
                ?? (new Campaign)->fbCampaignsUpdateOrCreate($act, $integrationDetId, $campaignInsights);

            $dataKeys = [
                'campaign_name',
                'campaign_id',
                'action_values',
                'actions',
                'cost_per_action_type',
                'cost_per_conversion',
                'date_start',
                'date_stop',
            ];

            if (!in_array($key, $dataKeys)) {

                $insight = Insight::where('account', $act)
                        ->where('provider_insight', $key)
                        ->where('integration_det', $integrationDetId)->first()
                    ?? (new Insight)->fbInsightsUpdateOrCreate($act, $integrationDetId, $key);

                $this->fbCampaignsInsightsUpdateOrCreate($act, $campaign->id, 'kpis', $insight->id,
                    $campaignInsightsDet,
                    $campaignInsights->date_start);
            }

            if ($key === 'action_values' or $key === 'actions') {

                foreach ($campaignInsightsDet as $campaignInsight) {

                    $insight = Insight::where('account', $act)
                            ->where('provider_insight', $campaignInsight->action_type)
                            ->where('integration_det', $integrationDetId)->first()
                        ?? (new Insight)->fbInsightsUpdateOrCreate($act, $integrationDetId,
                            $campaignInsight->action_type);

                    $this->fbCampaignsInsightsUpdateOrCreate($act, $campaign->id, $key, $insight->id,
                        $campaignInsight->value, $campaignInsights->date_start);
                }
            }
        }
    }

    /**
     * @param $fbAdAccount
     * @param $fbToken
     * @param $datePreset
     * @param $limit
     * @param $before
     * @param $after
     * @return mixed|null
     */
    protected function getCampaignInsights(
        $fbAdAccount,
        $fbToken,
        $datePreset,
        $limit,
        $before,
        $after,
        $timeRange = null
    ) {
        $fields = 'campaign_name,campaign_id,spend,reach,impressions,clicks,action_values,actions';
        return (new Facebook)->getFbObjectInsights($fbAdAccount,
            $fbToken,
            $fields,
            null, 1,
            'campaign',
            $datePreset,
            1,
            $limit,
            $before,
            $after,
            $timeRange);
    }

    /**
     * @param $act
     * @param $campaignId
     * @param $group
     * @param $insight
     * @param $value
     * @param $date
     * @return mixed
     */
    protected function fbCampaignsInsightsUpdateOrCreate($act, $campaignId, $group, $insight, $value, $date)
    {
        return $this->updateOrCreate(
            [
                'account' => $act,
                'campaign' => $campaignId,
                'group' => $group,
                'insight' => $insight,
                'date' => $date,
            ],
            [
                'value' => $value,
            ]
        );
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $stat
     * @return array|null
     */
    public function getTrafficStats($act, $datePreset, $stat): ?array
    {
        list($startDate, $endDate) = (new Helper)->datePreset($datePreset);

        $currencies = IntegrationDet::where('account', $act)->where('key', 'fbAdAccount')->where('status',
            1)->distinct()->pluck('currency');

        foreach ($currencies as $currency) {

            $record = $this->getTrafficSummarySum($act, $currency, $startDate,
                date('Y-m-d', strtotime("-1 day", strtotime($endDate))));

            $trafficStat = new Stat;
            $trafficStat->act = $act;
            $trafficStat->stat = $stat;
            $trafficStat->value = $record;
            $trafficStat->currency = $currency;
            $trafficStat->datePreset = $datePreset;
            $trafficStats[] = $trafficStat;
        }
        if (!isset($trafficStats)) {
            return null;
        }
        return $trafficStats;
    }

    /**
     * @param $data
     * @param $column
     * @param $actionType
     * @param $fromDate
     * @param $toDate
     * @param $summary
     * @return mixed
     */
    public function fbExtraColumn($data, $column, $actionType, $fromDate, $toDate, $summary)
    {
        if ($summary == 'sum') {
            $insight = DB::select(DB::raw("select
                        campaigns_insights.account,
                        insights.integration_det,
                        campaigns_insights.campaign,
                        campaigns_insights.group,
                        IF(insights.name = 0, insights.name, insights.provider_insight) as insight,
                        sum(campaigns_insights.value) as value,
                            campaigns_insights.date as date

                        from campaigns_insights

                        left join insights
                            on  campaigns_insights.insight = insights.id

                        where campaigns_insights.account = :act
                        and campaigns_insights.campaign = :camp
                        and campaigns_insights.group = :actionType
                        and insights.provider_insight = :insight
                        and date >= :fromDate
                        and date <= :toDate;"),
                [
                    'act' => session()->get('account')->id,
                    'camp' => $data->id,
                    'insight' => $column,
                    'actionType' => $actionType,
                    'fromDate' => $fromDate,
                    'toDate' => $toDate
                ]);
        } elseif ($summary == 'count') {
            $insight = DB::select(DB::raw("select
                        campaigns_insights.account,
                        insights.integration_det,
                        campaigns_insights.campaign,
                        campaigns_insights.group,
                        IF(insights.name = 0, insights.name, insights.provider_insight) as insight,
                        count(campaigns_insights.value) as value,
                        campaigns_insights.date as date

                        from campaigns_insights

                        left join insights
                            on  campaigns_insights.insight = insights.id

                        where campaigns_insights.account = :act
                        and campaigns_insights.campaign = :camp
                        and insights.provider_insight = :insight
                        and campaigns_insights.group = :actionType
                        and date >= :fromDate
                        and date <= :toDate;"),
                [
                    'act' => session()->get('account')->id,
                    'camp' => $data->id,
                    'insight' => $column,
                    'actionType' => $actionType,
                    'fromDate' => $fromDate,
                    'toDate' => $toDate
                ]);
        } elseif ($summary == 'avg') {
            $insight = DB::select(DB::raw("select
                        campaigns_insights.account,
                        insights.integration_det,
                        campaigns_insights.campaign,
                        campaigns_insights.group,
                        IF(insights.name = 0, insights.name, insights.provider_insight) as insight,
                        avg(campaigns_insights.value) as value,
                        campaigns_insights.date as date

                        from campaigns_insights

                        left join insights
                            on  campaigns_insights.insight = insights.id

                        where campaigns_insights.account = :act
                        and campaigns_insights.campaign = :camp
                        and insights.provider_insight = :insight
                        and campaigns_insights.group = :actionType
                        and date >= :fromDate
                        and date <= :toDate;"),
                [
                    'act' => session()->get('account')->id,
                    'camp' => $data->id,
                    'insight' => $column,
                    'actionType' => $actionType,
                    'fromDate' => $fromDate,
                    'toDate' => $toDate
                ]);
        }
        return $insight[0]->value;
    }
}
