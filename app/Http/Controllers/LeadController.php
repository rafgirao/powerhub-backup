<?php

namespace App\Http\Controllers;

use App\DataTables\LeadDataTable;
use App\Jobs\LeadJob;
use App\Models\Lead;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LeadRequest as LeadsRequest;

class LeadController extends Controller
{
    public function index(LeadDataTable $dataTable)
    {
        (new Helper)->getAccountInfo();

        return $dataTable->render('leads.lead', [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $source = "Hotmart";

        if ($source === 'Active Campaign'){
//            dd('LeadController Active Campaign');
            LeadJob::dispatch(session()->get('account')->id, $source, 'Last 7 Days');
        } elseif ($source === 'Hotmart') {
//            dd('LeadController Hotmart');
            LeadJob::dispatch(session()->get('account')->id, $source, 'Last 7 Days');
        } else {
            echo "Erro na importação de leads";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(LeadsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Lead $leads
     * @return void
     */
    public function show(Lead $leads)
    {
        //dd( Lead::with('salesLeadProducts')->where('account', session()->get('account')->id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lead $leads
     * @return void
     */
    public function edit(Lead $leads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Lead $leads
     * @return Response
     */
    public function update(Request $request, Lead $leads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lead $leads
     * @return Response
     */
    public function destroy(Lead $leads)
    {
        //
    }
}
