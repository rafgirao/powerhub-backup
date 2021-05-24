<?php

namespace App\Http\Controllers;


use App\Http\Requests\IntegrationRequest;
use App\Models\Integration;
use App\Models\IntegrationDet;
use App\Jobs\FbCampaignInsightJob;
use App\Jobs\FbCampaignJob;
use App\Jobs\EmailCampaignJob;
use App\Jobs\FbInsightJob;
use App\Jobs\LeadJob;
use App\Jobs\ProductJob;
use App\Jobs\SaleJob;
use App\Jobs\TagJob;
use App\Models\ProjectDet;
use App\Services\Helper;
use App\Models\Stat;
use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use stdClass;


/**
 * Class IntegrationController
 * @package App\Http\Controllers
 * @mixin Eloquent
 */
class IntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        (new Helper)->getAccountInfo();

        return view('integrations.integration', [
            'modal' => session()->get('modal'),
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
            'acIntegration' => session()->get('account')->integrations()->get()->where('provider_name', 'Active Campaign')->first(),
            'acCredentials' => (new Integration)->acCredentials(session()->get('account')->id),
            'hotmartIntegration' => session()->get('account')->integrations()->get()->where('provider_name', 'Hotmart')->first(),
            'hotmartCredentials' => (new Integration)->hotmartCredentials(session()->get('account')->id),
            'fbIntegration' => session()->get('account')->integrations()->get()->where('provider_name', 'Facebook')->first(),
            'fbCredentials' => (new Integration)->fbCredentials(session()->get('account')->id),
            'fbAdAccountStatus' => (new IntegrationDet)->where('account', session()->get('account')->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('integrations.create', [
            'act' => session()->get('account')->id,
            'user' => Auth::user(),
            'company' => session()->get('account')->company,
            'accounts' => session()->get('accounts'),
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IntegrationRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(IntegrationRequest $request): RedirectResponse
    {
        $act = session()->get('account')->id;
        $validated = $request->validated();

        $integration = (new Integration)->createOrUpdateIntegration($act, $validated);

        if ($integration->provider_name === 'Active Campaign'){
            TagJob::dispatch($act, 'Active Campaign');
            EmailCampaignJob::dispatch($act, 'Active Campaign');
            LeadJob::dispatch($act, 'Active Campaign', 'All');
        }

        if ($integration->provider_name === 'Hotmart') {
            ProductJob::dispatch($act, 'Hotmart', 'All');
            LeadJob::dispatch($act, 'Hotmart', 'All');
            SaleJob::dispatch($act, 'Hotmart', 'All');
        }
        if ($integration->provider_name === 'Facebook') {
            FbCampaignJob::dispatch($act, 'Facebook');
            FbInsightJob::dispatch($act, 'Facebook');
            FbCampaignInsightJob::dispatch($act, 'Facebook', 180);
        }

        return redirect()->route('integrations');
    }

    /**
     * Display the specified resource.
     *
     * @param Integration $integrations
     * @return Response
     */
    public function show(Integration $integrations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Integration $integrations
     * @return Response
     */
    public function edit(Integration $integrations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Integration $integrations
     * @return Response
     */
    public function update(Request $request, Integration $integrations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integration $integration
     * @return RedirectResponse
     */
    public function destroy(Integration $integration)
    {
        $act = $integration->getAccount()->first()->id;
        Stat::where('account', $act)->delete();
        Artisan::call('stats');

        if ($integration->provider_name === 'Active Campaign'){
            ProjectDet::where('account', $act)->where('key_type', 'App\Models\Tag')->delete();
            ProjectDet::where('account', $act)->where('key_type', 'App\Models\EmailCampaign')->delete();
        }

        if ($integration->provider_name === 'Hotmart'){
            ProjectDet::where('account', $act)->where('key_type', 'App\Models\Product')->delete();
        }

        if ($integration->provider_name === 'Facebook'){
            IntegrationDet::where('account', $act)->where('integration', $integration->id);
            ProjectDet::where('account', $act)->where('key_type', 'App\Models\Campaign')->delete();
        }

        if ($integration->provider_name === 'Google'){
            IntegrationDet::where('account', $act)->where('integration', $integration->id);
            ProjectDet::where('account', $act)->where('key_type', 'App\Models\Sheet')->delete();
        }

        $integrationName = $integration->provider_name;
        Integration::destroy($integration->id);

        session()->flash('alert',"A integração {$integrationName} foi deletada com sucesso!");
        return redirect()->route('integrations');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function createGoogleIntegration(): RedirectResponse
    {
        session()->reflash();

        $act = session()->get('account')->id;
        $googleRefreshToken = session()->get('googleRefreshToken');

        $validated['providerName'] = 'Google';
        $validated['description'] = 'Google 01';
        $validated['providerType'] = 'GoogleAccount';
        $validated['googleRefreshToken'] = $googleRefreshToken;
        (new Integration)->createOrUpdateIntegration($act, $validated);

        return redirect()->route('sheets.create');
    }

}
