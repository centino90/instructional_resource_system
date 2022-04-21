<?php

namespace App\DataTables\Reports;

use App\DataTables\DataTable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class InstructorDataTable extends DataTable
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
            ->addColumn('name', function ($row) {
                return "{$row->name}";
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('user.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Details</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->filterColumn('name', function (Builder $query) use ($request) {
                return $query->where('fname', 'LIKE', Str::lower($request->get('search')['value']));
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
    public function query(User $model)
    {
        return $model
            ->with('resources', 'lessons', 'activityLogs')
            ->withCount('resources', 'lessons', 'activityLogs')
            ->whereHas('programs', fn ($query) => $query->whereIn('id', auth()->user()->programs->pluck('id')))
            ->instructors();
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
            Column::make('name'),
            Column::make('email'),
            Column::make('resources_count')->searchable(false),
            Column::make('lessons_count')->searchable(false),
            Column::make('activity_logs_count')->searchable(false),
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
