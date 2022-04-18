<?php

namespace App\DataTables\User;

use App\DataTables\DataTable;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Html\Column;


class UserActivitiesDataTable extends DataTable
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
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('activities.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Activity $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Activity $model)
    {
        return $model
            ->where('causer_id', auth()->id());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->sharedBuilder()
            ->columns($this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('created_at'),
            Column::make('log_name'),
            Column::make('description'),
            Column::computed('action', '')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Activities_' . date('YmdHis');
    }
}
