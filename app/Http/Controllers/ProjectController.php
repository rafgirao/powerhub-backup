<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectDataTable;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\Helper;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProjectDataTable $dataTable
     * @return Application|Factory|View|Response
     */
    public function index(ProjectDataTable $dataTable)
    {
        (new Helper)->getAccountInfo();

        return $dataTable->render('projects.project', [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
            'modal' => session()->get('modal'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        list($tags, $products, $kpis, $fbCampaigns) = (new Project)->getProjectParameters();

        return view('projects.create', [
            'tags' => ($tags ?? null),
            'products' => ($products ?? null),
            'fbCampaigns' => ($fbCampaigns ?? null),
            'kpis' => ($kpis ?? null),
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        (new Project)->createOrUpdateProject($request);
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return Application|Factory|View
     */
    public function show(Project $project)
    {
        (new Helper)->isModelFromTheSameAccount($project->account);
        (new Helper)->assignProjectCurrency($project);

        list($project,
            $videos,
            $videoStats,
            $tagStats,
            $saleStats,
            $trafficStats,
            $roiStats,
            $trafficChartStats,
            $productCount,
            $saleChartStats,
            $stats) = (new Helper)->getReportParameters($project);

        $data = [
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
            'reportType' => 'performance',
        ];

        return view('reports.performance.show', $data);
    }

    public function conception(Project $project)
    {
        (new Helper)->isModelFromTheSameAccount($project->account);
        (new Helper)->assignProjectCurrency($project);

        $data = [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
            'project' => ($project ?? null),
            'reportType' => 'conception',
        ];

        return view('reports.conception.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
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
        return view('projects.edit', $data);
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
        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function destroy(Project $project): RedirectResponse
    {
        $projectName = $project->name;
        Project::destroy($project->id);
        session()->flash('alert', "O projeto $projectName foi deletado com sucesso!");
        return redirect()->route('projects.index');
    }
}
