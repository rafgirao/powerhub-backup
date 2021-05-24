<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Integration;
use App\Models\Sale;
use App\Services\Helper;
use App\Models\Stat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        (new Helper)->getAccountInfo();
        $act = session()->get('account')->id;

        if (Integration::all()->isEmpty()) {
            return redirect(route('integrations'));
        }

        $datePreset = 'Last 7 Days';
        $currency = 'BRL';

        if (request()->input('currency')) {
            session(['currency' => request()->input('currency')]);
        }
        if (session()->has('currency')) {
            $currency = session()->get('currency');
        }
        if (session()->has('datePreset')) {
            $datePreset = session()->get('datePreset');
        }

        $stats = (new Stat)->dashStats($act, $datePreset, $currency);
        $sales = (new Sale)->latest()->limit(10)->with('getLead', 'getProduct')->get();

        return view('dash.dashboard', [ 'stats' => $stats, 'sales' => $sales, 'reportType' => 'dashboard',]);
    }

    public function show(Request $request)
    {
        if (!isset($request->account)) {
            return redirect()->back();
        }

        session(['account' => Account::find($request->account)]);
        (new Helper)->userHasAccessToAccount($request->account);

        if ($request->currency) {
            session(['currency' => $request->currency]);
        }
        if ($request->datePreset){
            session(['datePreset' => $request->datePreset]);
        }

        return redirect(route('home'));
    }
}
