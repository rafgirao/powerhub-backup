<?php

namespace App\DataTables;

use App\Models\Project;
use Carbon\Carbon;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class ProjectDataTable extends DataTable
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
            ->addColumn('start_at_for_humans', function ($data) {
                return Carbon::parse($data->start_at)->diffForHumans();
            })
            ->addColumn('end_at_for_humans', function ($data) {
                return Carbon::parse($data->end_at)->diffForHumans();
            })
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
        return view('projects.buttons',[
            'project'=> $data,
        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Project $model
     * @return Builder
     */
    public function query(Project $model)
    {
        return Project::where('id', ">", 0)->where('account',session()->get('account')->id)->with('getProjectsDet')->orderBy('updated_at', 'DESC');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('projects')
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
            ])
            ->orderBy(0)
            ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('id', 'Id'),
            Column::computed('name', 'Nome'),
            Column::computed('description', 'Descrição'),
            Column::computed('start_at_for_humans', 'Início'),
            Column::computed('end_at_for_humans', 'Fim'),
            Column::computed('action', 'Ações')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Project_' . date('YmdHis');
    }
}
