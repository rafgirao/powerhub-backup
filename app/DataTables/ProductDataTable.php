<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;


class ProductDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            });
    }

    /**
     *
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $detailsUrl = route('products.show', ['act' => session()->get('account')->id, 'product' => $data->id]);

        return view('products.buttons', [
            'id' => $data->id,
            'detailsUrl' => $detailsUrl,
            'coverPhoto' => $data->cover_photo,
        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Product $model
     * @return Builder
     */
    public function query(Product $model)
    {
        return Product::where('id', ">", 0)->where('account',session()->get('account')->id)->orderBy('updated_at', 'DESC');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('products')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-6 col-sm-6'B><'col-6 col-sm-6'f>>".
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'p>>")
            ->buttons(
                Button::make('copy')->text('<i class="fa fa-copy"></i>')->className('btn btn-primary')->customize(['class'=>'btn btn-primary'])->addClass('btn btn-primary'),
                Button::make('csv')->text('<i class="fa fa-file-csv"></i>'),
                Button::make(['extend' => 'excel', 'text' => 'Excel']),
            )
            ->parameters([
//                'pagingType' => 'full',
                'responsive' => true,
                'autoWidth' => false,
                'language' => ['decimal' => ',', 'thousands' => '.'],
                'lengthMenu' => [[10, 25, 100, 250, 1000], [10, 25, 100, 250, 1000]],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            'action' => ['title' => 'AÇÃO'],
            'product_name' =>  ['title' => 'Nome'],
            'seller_name' =>  ['title' => 'Vendedor'],
            'payment_mode' =>  ['title' => 'Forma Pgto'],
            'coproduction' =>  ['title' => 'Coprodução'],
            'approved' =>  ['title' => 'Aprovação'],
            'revised' =>  ['title' => 'Revisão'],
            'enabled' =>  ['title' => 'Ativação'],
            'deleted' =>  ['title' => 'Delação'],
            'pixel' =>  ['title' => 'Pixel'],
            'smart_installment' =>  ['title' => 'Pgto Inteligente'],
            'price' =>  ['title' => 'Preço'],
            'price_currency' =>  ['title' => 'Moeda'],
            'payment_engine' =>  ['title' => 'Gateway'],
            'status' =>  ['title' => 'Status'],
            'gateway_creation_date' =>  ['title' => 'Data Criação'],
            'gateway_product_id' =>  ['title' => 'Id'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Product_' . date('YmdHis');
    }

}
