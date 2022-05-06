<?php

namespace App\DataTables\Reports;

use App\DataTables\DataTable;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;

class InstructorActivitiesDataTable extends DataTable
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
     * @param \App\Models\ActivityLog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ActivityLog $model)
    {
        $startDate = !empty(request()->get('start_date')) ? Carbon::make(request()->get('start_date'))->endOfDay() : now()->subYear(1)->endOfDay();
        $endDate = !empty(request()->get('end_date')) ? Carbon::make(request()->get('end_date'))->endOfDay() : now()->endOfDay();

        $activityTypes = ActivityLog::select('log_name')->groupBy('log_name')->get()->filter(fn ($log) => !collect(['user-created', 'file-deleted'])->contains($log->log_name));

        return $model->whereIn('causer_id', auth()->user()->programs()->first()->users()->withTrashed()->instructors()->pluck('id'))
            ->with('causer')
            ->whereIn('log_name', $activityTypes)
            ->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->sharedBuilder(true, false)->columns($this->getColumns());
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
