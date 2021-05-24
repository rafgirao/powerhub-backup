<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\IntegrationDet;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CampaignInsightController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function facebook(Request $request)
    {
        (new Helper)->getAccountInfo();
        $act = session()->get('account')->id;

        if (request()->ajax()) {
            $statusFilter = $request->status_filter ?: null;
            $accountFilter = $request->account_filter ?: null;
            $fbFromDate = $request->from_date ?: date('Y-m-d', strtotime("-7 days"));
            $fbToDate = $request->to_date ?: date('Y-m-d', strtotime("0 days"));
            $fbEvent = $request->event_filter ?: null;

            $data = DB::table('campaigns')
                ->selectRaw("integrations_det.currency, campaigns.id, campaigns.account, campaigns.integration_det, campaigns.provider_campaign_id, campaigns.provider_campaign_name, campaigns.status, campaigns_insights.group,
                SUM(CASE WHEN insights.provider_insight = 'spend' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END) spend,
                SUM(CASE WHEN insights.provider_insight = 'reach' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END) reach,
                SUM(CASE WHEN insights.provider_insight = 'impressions' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END) impressions,
                SUM(CASE WHEN insights.provider_insight = 'clicks' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END) clicks,
                (
                SUM(CASE WHEN insights.provider_insight = 'impressions' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END) /
                SUM(CASE WHEN insights.provider_insight = 'reach' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END)
                ) as frequency,
                (
                SUM(CASE WHEN insights.provider_insight = 'spend' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END)/
                SUM(CASE WHEN insights.provider_insight = 'impressions' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END) *1000
                ) as cpm,
                (
                SUM(CASE WHEN insights.provider_insight = 'spend' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END)/
                SUM(CASE WHEN insights.provider_insight = 'clicks' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END)
                ) as cpc,
                (
                SUM(CASE WHEN insights.provider_insight = 'clicks' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END)/
                SUM(CASE WHEN insights.provider_insight = 'impressions' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END) *100
                ) as ctr,
                SUM(CASE WHEN insights.provider_insight = ? AND campaigns_insights.group = 'actions' THEN campaigns_insights.value END) as event,
                SUM(CASE WHEN insights.provider_insight = ? AND campaigns_insights.group = 'action_values' THEN campaigns_insights.value END) as event_value,
                (
                SUM(CASE WHEN insights.provider_insight = 'spend' AND campaigns_insights.group = 'kpis' THEN campaigns_insights.value END)/
                SUM(CASE WHEN insights.provider_insight = ? AND campaigns_insights.group = 'actions' THEN campaigns_insights.value END)
                ) as event_cost
                ", [$fbEvent, $fbEvent, $fbEvent])
                ->join('campaigns_insights', 'campaigns.id', '=', 'campaigns_insights.campaign')
                ->join('insights', 'campaigns_insights.insight', '=', 'insights.id')
                ->join('integrations_det', 'integrations_det.id', '=', 'campaigns.integration_det')
//                ->where('campaigns.account', '=', $act)
                ->where('integrations_det.account', '=', $act)
                ->where('campaigns_insights.account', '=', $act)
//                ->where('insights.account', '=', $act)
                ->whereBetween('campaigns_insights.date', [$fbFromDate, $fbToDate])
                ->when($statusFilter, function ($q) use ($statusFilter) {
                    return $q->where('campaigns.status', '=', $statusFilter);
                })
                ->when($accountFilter, function ($r) use ($accountFilter) {
                    return $r->where('campaigns.integration_det', '=', $accountFilter);
                })
                ->groupBy('campaigns.provider_campaign_name')
                ->get();

            return datatables()
                ->of($data)
                ->make(true);
        }

        return view('campaigns.facebook', [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
            'insights' => Insight::where('account', '=', session()->get('account')->id)->where('name', '<>',
                null)->where('name', '<>', 'spend')->with('getIntegrationDet')->get()->keyBy('br_name'),
            'fbAdAccounts' => IntegrationDet::where('account', '=', session()->get('account')->id)->where('key', '=',
                'fbAdAccount')->where('status', '=', 1)->distinct('description')->pluck('id', 'description'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $data
     * @return mixed
     */

}
