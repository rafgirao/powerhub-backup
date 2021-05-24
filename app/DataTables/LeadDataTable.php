<?php

namespace App\DataTables;

use App\Models\Lead;
use App\Services\Helper;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Creativeorange\Gravatar\Facades\Gravatar;

class LeadDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
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
        $photo = Gravatar::get($data->email ?? 'example@gmail.com');
        $whatsUrl = (new Helper)->getWhatsUrl($data->phone_number, $data->first_name, "Oi%20", ",%20tudo%20bem?");
        $detailsUrl = route('leads.show', ['lead' => $data->id]);

        return view('leads.buttons', [
            'phoneNumber' => $data->phone_number,
            'id' => $data->id,
            'detailsUrl' => $detailsUrl,
            'whatsUrl' => $whatsUrl,
            'photo' => $photo
        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Lead $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lead $model)
    {
        return Lead::where('id', ">", 0)->orderBy('updated_at', 'DESC');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('leads')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-6 col-sm-6'B><'col-6 col-sm-6'f>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'p>>")
            ->buttons(
                Button::make('copy')->text('<i class="fa fa-copy"></i>')->className('btn btn-primary')->customize(['class' => 'btn btn-primary'])->addClass('btn btn-primary'),
                Button::make('csv')->text('<i class="fa fa-file-csv"></i>'),
//                Button::make(['extend' => 'excel', 'text' => 'Excel']),
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
            'action' => ['title' => 'Ações / Avatar'],
            'first_name' => ['title' => 'Nome'],
            'last_name' => ['title' => 'SobreNome'],
            'email' => ['title' => 'Email'],
            'phone_number' => ['title' => 'Telefone'],
            'country' => ['title' => 'País'],
            'state' => ['title' => 'Estado'],
            'city' => ['title' => 'Cidade'],
            'zipcode' => ['title' => 'CEP'],
            'address' => ['title' => 'Endereço'],
            'number' => ['title' => 'Número'],
            'complement' => ['title' => 'Complemento'],
            'neighborhood' => ['title' => 'Bairro'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Lead_' . date('YmdHis');
    }
}
