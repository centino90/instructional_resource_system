<?php

namespace App\DataTables;

use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReportsInstructorDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $request = request();
        return datatables()
            ->eloquent($query)
            ->setRowId(function ($row) {
                return "subject{$row->id}";
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('activities.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Details</a>';
                $btn .= '<a href="' . route('user.show', $row->causer) . '" class="btn btn-sm btn-primary border fw-bold text-nowrap">View profile</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('instructor', function ($row) {
                return $row->causer->name;
            })
            ->rawColumns(['action'])
            ->editColumn('activity', function ($data) {
                return $data->log_name;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
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
        $year = Carbon::make(request()->get('year'))->year ?? now()->year;
        $activityTypes = Activity::select('log_name')->groupBy('log_name')->get()->filter(fn ($log) => !collect(['user-created', 'file-deleted'])->contains($log->log_name));
        $type = request()->get('type') ?  [request()->get('type')] : $activityTypes;

        return $model->whereIn('causer_id', auth()->user()->programs()->first()->users()->where('role_id', Role::INSTRUCTOR)->pluck('id'))
            ->with('causer')
            ->whereIn('log_name', $type)
            ->whereYear('created_at', $year);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->pageLength(5)
            ->lengthMenu([5, 10, 20, 50, 100])
            ->responsive(true)
            ->setTableId('reports-resources-table')
            ->columns($this->getColumns())
            ->fixedColumnsLeftColumns(1)
            ->fixedColumnsRightColumns(1)
            ->minifiedAjax()
            ->selectStyleMulti()
            ->stateSave(true)
            ->stateSaveParams('function(settings, data) {
            data.search.search = ""
        }')
            ->dom('Bplfrtipl')
            ->buttons(
                Button::make(['extend' => 'export', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make(['extend' => 'print', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make([
                    'extend' => 'reset',

                    'className' => 'border btn text-primary',
                    'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}'
                ]),
                Button::make(['extend' => 'reload', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
            );
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
            Column::make('instructor', 'causer.fname'),
            Column::make('activity', 'log_name'),
            Column::make('description'),
            Column::make('created_at'),
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
        return 'ReportsInstructor_' . date('YmdHis');
    }
}
