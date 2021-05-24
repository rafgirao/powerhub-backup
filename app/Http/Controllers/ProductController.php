<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Jobs\ProductJob;
use App\Models\Product;
use App\Models\Account;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index(ProductDataTable $dataTable)
    {
        (new Helper)->getAccountInfo();

        return $dataTable->render('products.product', [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $act
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create($act, $provider)
    {
        if ($source = 'Hotmart'){
            ProductJob::dispatch($act, $provider);
            session()->flash('message','A importação de produtos foi iniciada!');
            return redirect()->route('products');
        } else {
            echo "Problema na importação de Produtos";
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($act, $product)
    {
        dd($act, $product);
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

}
