<?php

namespace App\Http\Controllers;

use App\Jobs\SaleJob;
use App\Models\Product;
use App\Models\Sale;
use App\Services\Helper;
use App\Services\Hotmart;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        (new Helper)->getAccountInfo();
        $act = session()->get('account')->id;

        if (request()->ajax()) {
            $statusFilter = $request->status_filter;
            $productFilter = $request->product_filter;
            $paymentFilter = $request->payment_filter;
            $fromDate = $request->from_date;
            $toDate = $request->to_date;

            $data = DB::table('sales')
                ->selectRaw("sales.account, sales.id, sales.transaction, sales.purchase_date, sales.commission, sales.commission_currency, sales.price,
                        sales.price_currency, sales.payment_type, sales.payment_method, sales.payment_mode,
                        sales.recurrence_number, sales.warranty_refund, sales.installments_number,
                        sales.affiliate, sales.status, products.account, products.id , products.product_name,
                        leads.id, leads.first_name,
                        leads.last_name,leads.email, leads.phone_number")
                ->join('leads', 'leads.id', '=', 'sales.lead')
                ->join('products', 'products.id', '=', 'sales.product')
                ->where('sales.account', '=', $act)
                ->when($statusFilter, function ($q) use ($statusFilter) {
                    return $q->where('sales.status', '=', $statusFilter);
                })
                ->when($productFilter, function ($r) use ($productFilter) {
                    return $r->where('products.id', '=', $productFilter);
                })
                ->when($paymentFilter, function ($s) use ($paymentFilter) {
                    return $s->where('sales.payment_type', '=', $paymentFilter);
                })
                ->when($fromDate and $toDate, function ($t) use ($fromDate, $toDate) {
                    return $t->whereBetween('purchase_date', array($fromDate, (new Helper)->addDays($toDate, 1)));
                })
                ->when(!$fromDate or !$toDate, function ($u) use ($fromDate, $toDate) {
                    return $u->whereBetween('purchase_date',
                        array(date('Y-m-d', strtotime("-7 days")), date('Y-m-d', strtotime("1 days"))));
                })
                ->get();

            return datatables()
                ->of($data)
                ->addColumn('action', function ($data) {

                    $whatsUrl = (new Helper)->getWhatsUrl($data->phone_number, $data->first_name, "Oi%20",
                        ",%20tudo%20bem?");
                    $detailsUrl = route('sales.show', ['act' => session()->get('account')->id, 'sale' => $data->id]);

                    return view('sales.buttons', [
                        'phoneNumber' => $data->phone_number,
                        'id' => $data->id,
                        'detailsUrl' => $detailsUrl,
                        'whatsUrl' => $whatsUrl
                    ]);
                })
                ->addColumn('purchase_date_for_humans', function ($data) {
                    return Carbon::parse($data->purchase_date)->diffForHumans();
                })
                ->addColumn('br_commission', function ($data) {
                    return (new Helper)->brFormatCurrency($data->commission_currency, $data->commission);
                })
                ->addColumn('br_price', function ($data) {
                    return (new Helper)->brFormatCurrency($data->price_currency, $data->price);
                })
                ->addColumn('br_status', function ($data) {
                    return (new Sale)->getSaleStatus($data->status);
                })
                ->make(true);
        }

        return view('sales.sale', [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
            'products' => Product::all(),
            'statuses' => Sale::where('status','<>', null)->distinct('status')->pluck('status'),
            'payments' => Sale::where('payment_type','<>', null)->distinct('payment_type')->pluck('payment_type'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $act
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        $act = session()->get('account')->id;
        $source = "Hotmart";
        if ($source === 'Hotmart') {
            SaleJob::dispatch($act, 'Hotmart', 'All');
            session()->flash('message', 'A importação de vendas foi iniciada!');
            return redirect()->route('sales', ['act' => $act]);
        } else {
            echo "Problema na importação de Vendas";
        }

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
     * @param \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

}
