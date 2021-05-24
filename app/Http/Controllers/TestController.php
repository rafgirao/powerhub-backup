<?php

namespace App\Http\Controllers;

use App\Models\LeadTag;
use App\Models\Sale;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function helloWorld()
    {
        dd('Hello World');
    }

    public function alert()
    {
        return view('pages.alert');
    }

    public function changeSaleStatus()
    {
        $sales = Sale::where('status', 'COMPLETE')->get();

        foreach ($sales as $sale) {
            $status =  (new Sale)->setSaleStatus($sale['status']);
            $sale->status = $status;
            $sale->save();
        }

        var_dump('done');
    }

    public function leadTag()
    {
        $act = 21417;
        $datePreset = 'Today';
        (new LeadTag)->prepareAcLeadTag($act, $datePreset, 'updatedAt');
    }
}
