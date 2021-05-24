<?php

namespace App\Http\Controllers;

use App\DataTables\DebriefingDataTable;
use App\Models\EmailCampaign;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\Helper;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;


class DebriefingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DebriefingDataTable $dataTable
     * @return Application|Factory|View|Response
     */
    public function index(DebriefingDataTable $dataTable)
    {
        (new Helper)->getAccountInfo();

        return $dataTable->render('debriefings.debriefing', [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
        ]);
    }

    /**
     * @param Project $project
     * @return Application|Factory|View
     */
    public function show(Project $project)
    {
        (new Helper)->isModelFromTheSameAccount($project->account);
        (new Helper)->assignProjectCurrency($project);

        list($project, $videos, $videoStats, $tagStats, $saleStats, $trafficStats, $roiStats, $trafficChartStats, $productCount, $saleChartStats, $stats) = (new Helper)->getReportParameters($project);

        $nicheGrowth = isset($project->niche) ? (new Helper)->getTrends($project->niche) : 0;
        $subNicheGrowth = isset($project->sub_niche) ? (new Helper)->getTrends($project->sub_niche) : 0;

        $project->nicheGrowth = (isset($project->niche) and isset($nicheGrowth[0]) and $nicheGrowth[0] !== 0 and $nicheGrowth[0] !== null and $nicheGrowth[0] !== '') ? number_format(($nicheGrowth[1]-$nicheGrowth[0])/$nicheGrowth[0]*100, '1',',', '.' ) : 0;
        $project->subNicheGrowth = (isset($project->sub_niche) and isset($subNicheGrowth[0]) and $subNicheGrowth[0] !== 0 and $subNicheGrowth[0] !== null and $subNicheGrowth[0] !== '') ? number_format(($subNicheGrowth[1]-$subNicheGrowth[0])/$subNicheGrowth[0]*100, '1',',', '.' ) : 0;
        $project->instagramGrowth = (isset($project->instagram_followers_before) and $project->instagram_followers_before !== 0 and $project->instagram_followers_before !== null and $project->instagram_followers_before !== '') ? number_format(($project->instagram_followers_after-$project->instagram_followers_before)/$project->instagram_followers_before*100, '1',',', '.' ) : 0;
        $project->facebookGrowth = (isset($project->facebook_fans_before) and $project->facebook_fans_before !== 0 and $project->facebook_fans_before !== null and $project->facebook_fans_before !== '') ? number_format(($project->facebook_fans_after-$project->facebook_fans_before)/$project->facebook_fans_before*100, '1',',', '.' ) : 0;
        $project->youtubeGrowth = (isset($project->youtube_subscribers_before) and $project->youtube_subscribers_before !== 0 and $project->youtube_subscribers_before !== null and $project->youtube_subscribers_before !== '') ? number_format(($project->youtube_subscribers_after-$project->youtube_subscribers_before)/$project->youtube_subscribers_before*100, '1',',', '.' ) : 0;
        $project->leads = max(explode('|', $tagStats->values));
        $project->salesGrowthMin = (isset($project->revenue_goal_min) and $project->revenue_goal_min !== 0) ? number_format(($saleStats['Realizada']['sum']-$project->revenue_goal_min)/$project->revenue_goal_min*100, '1',',', '.' ) : 0;
        $project->salesGrowthMedium = (isset($project->revenue_goal) and $project->revenue_goal !== 0) ? number_format(($saleStats['Realizada']['sum']-$project->revenue_goal)/$project->revenue_goal*100, '1',',', '.' ) : 0;
        $project->salesGrowthMax = (isset($project->revenue_goal_max) and $project->revenue_goal_max !== 0) ? number_format(($saleStats['Realizada']['sum']-$project->revenue_goal_max)/$project->revenue_goal_max*100, '1',',', '.' ) : 0;
        $project->emailCampaigns = (new EmailCampaign)->where('account', $project->account)->whereBetween('last_sent_date',[$project->start_at, $project->end_at])->get();
        $project->emailCampaignsSendsSum = $project->emailCampaigns->sum('sends');

        $project->salesGrowth = (new Helper)->salesGrowth($project->salesGrowthMin, $project->salesGrowthMedium, $project->salesGrowthMax);
        $project->salesGrowthFlag = (new Helper)->salesGrowthFlag($project->salesGrowthMin, $project->salesGrowthMedium, $project->salesGrowthMax);

//        dd($project->salesGrowthMin, $project->salesGrowthMedium, $project->salesGrowthMax, $project->salesGrowth, $project->salesGrowthFlag);

        $data = [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
            'trafficItem' => 0,
            'salesItem' => 0,
            'project' => ($project ?? null),
            'stats' => ($stats ?? null),
            'tagStats' => ($tagStats ?? null),
            'saleStats' => ($saleStats ?? null),
            'trafficStats' => ($trafficStats ?? null),
            'trafficChartStats' => ($trafficChartStats ?? null),
            'saleChartStats' => ($saleChartStats ?? null),
            'roiStats' => ($roiStats ?? null),
            'productCount' => ($productCount ?? null),
            'videoStats' => ($videoStats ?? null),
            'videos' => ($videos ?? null),
            'reportType' => 'debriefing',
        ];

        return view('reports.debriefing.show', $data);
    }


    /**
     * @param Project $project
     * @return Application|Factory|View
     */
    public function edit(Project $project)
    {
        (new Helper)->isModelFromTheSameAccount($project->account);
        if (session()->get('redirect')) {
            return view('errors.403');
        }

        $data = (new Project)->projectViewData($project);
        return view('debriefings.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(ProjectRequest $request, $id): RedirectResponse
    {
        (new Project)->createOrUpdateProject($request, $id);
        return redirect()->route('debriefings.index');
    }
}
