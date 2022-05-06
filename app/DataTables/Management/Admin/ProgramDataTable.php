<?php

namespace App\DataTables\Management\Admin;

use App\DataTables\DataTable;
use App\Models\Program;
use Yajra\DataTables\Html\Column;
class ProgramDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $searchVal = request()->get('search')['value'];

        return datatables()
            ->eloquent($query)
            ->setRowId(function ($row) {
                return "subject{$row->id}";
            })
            ->addColumn('dean', function ($row) {
                if ($row->users()->deans()->count() > 1) {
                    return implode(',', $row->users()->deans()->pluck('fname')->all());
                } elseif ($row->users()->deans()->count() == 1) {
                    return $row->users()->deans()->first()->getNameAttribute();
                } else {
                    return 'No Program Dean';
                }
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at;
            })
            ->addColumn('trashed_at', function ($row) {
                return $row->deleted_at;
            })
            ->addColumn('action', function ($row) {
                return $this->sharedWithoutViewActions(
                    $row,
                    route('admin.programs.edit', $row->id),
                    route('admin.programs.destroy', $row->id),
                    $row->code
                );
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Program $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Program $model)
    {
        $model = $model
            ->with(['courses', 'users']);

        return $this->modelStoreType($model, ['archived']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->sharedBuilder(true)
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
            Column::make('id'),
            Column::make('code'),
            Column::make('title'),
            Column::make('dean'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('trashed_at'),
            Column::computed('action', '')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Courses_' . date('YmdHis');
    }
}
