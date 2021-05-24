<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use App\Jobs\SheetJob;
use App\Models\Project;
use App\Models\ProjectDet;
use App\Services\Google;
use App\Models\Sheet;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use stdClass;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        if ($_GET['project']) {
            session()->forget('modal');
            session()->forget('googleRefreshToken');
            session()->forget('project');
            session()->forget('scope');
            session()->forget('sheet');
            session()->forget('alert');

            $act = session()->get('account')->id;
            $project = Project::where('id', $_GET['project'])->first();
            session()->flash('project', $project);
            session()->flash('scope', $_GET['scope']);

            $refreshToken = (new Google)->getRefreshToken($act);

            if (!isset($refreshToken)) {
                return redirect()->route('google.start', ['scope' => session()->get('scope')]);
            }

            session()->flash('googleRefreshToken', $refreshToken);

            $projectsDet = $project->getProjectsDet->where('account', $act)->where('key_type', 'App\Sheet')->first();

            if (!isset($projectsDet)){
                return redirect()->route('sheets.create');
            }

            $sheet = $projectsDet->keyable;

            session()->flash('sheet', $sheet);
            session()->flash('modal', 'Sheets Modal');
            return redirect()->route('projects.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function create(): RedirectResponse
    {
        session()->reflash();
        $act = session()->get('account')->id;
        $project = session()->get('project');

        $refreshToken = (new Google)->getRefreshToken($act);
        $accessToken = (new Google)->getAccessToken($refreshToken);

        $projectsDet = $project->getProjectsDet->where('account', $act)->where('key_type', 'App\Sheet')->first();

        if (isset($projectsDet)){
            $sheet = $projectsDet->keyable;
            ProjectDet::destroy($projectsDet->id);
        }

        if (isset($sheet)){
            Sheet::destroy($sheet->id);
        }

        $googleSheet = (new Google)->createSpreadsheet($accessToken,'Planilha de Vendas e Recuperação - ' . $project->name);

        if (!isset($googleSheet)) {
            return redirect()->route('google.start', ['scope' => session()->get('scope')]);
        }

        $sheet = Sheet::create([
            'account' => $act,
            'sheet_id' => $googleSheet->spreadsheetId,
            'description' => $project->name,
        ]);

        (new Google)->updateSpreadsheet($accessToken, $sheet);

        session()->flash('sheet', $sheet);

        $request = new stdClass();
        $request->sheet = $sheet;
        $request->fieldsUpdate[] = 'sheet';

        (new ProjectDet)->createOrUpdateProjectDet($project, $request);

        session()->flash('modal', 'Sheets Modal');
        SheetJob::dispatch($project, 0)->onQueue('alldata');
        return redirect()->route('projects.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     * @throws Exception
     */
    public function store(): Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sheet $sheet
     * @return RedirectResponse
     */
    public function destroy(Sheet $sheet): RedirectResponse
    {
        $sheetName = $sheet->description;
        $projectDet = $sheet->getProjectDetByKey->first();

        Sheet::destroy($sheet->id);
        ProjectDet::destroy($projectDet->id);
        session()->flash('alert', "A planilha $sheetName foi deletada com sucesso!");
        return redirect()->route('projects.index');
    }
}
