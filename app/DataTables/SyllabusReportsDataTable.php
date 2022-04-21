<?php

namespace App\DataTables;

use App\Models\Course;
use App\Models\Resource;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SyllabusReportsDataTable extends DataTable
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
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Details</a>';
                $btn .= '</div>';

                return $btn;
            })
            ->addColumn('course', function ($row) {
                return "{$row->course->title} ({$row->course->code})";
            })
            ->addColumn('lesson', function ($row) {
                return $row->lesson ? $row->lesson->title : '';
            })
            ->addColumn('current_media', function ($row) {
                return $row->currentMediaVersion ? $row->currentMediaVersion->file_name : 'unknown file';
            })
            ->addColumn('submitter', function ($row) {
                return $row->user->name;
            })
            ->addColumn('versions', function ($row) {
                return $row->getMedia()->count();
            })
            ->addColumn('submission_status', function ($row) {
                return $row->is_delayed ? "<span class='badge bg-danger text-white'>Delayed</span>" : "<span class='badge bg-success text-white'>On Time</span>";
            })
            ->addColumn('verification_status', function ($row) {
                if ($row->verification_status == 'Approved') {
                    return "<span class='badge bg-success text-white'>{$row->verification_status}</span>";
                } else {
                    return "<span class='badge bg-warning text-white'>{$row->verification_status}</span>";
                }
            })
            ->addColumn('storage_status', function ($row) {
                return "<span class='badge bg-secondary text-white'>{$row->storage_status}</span>";
            })
            ->addColumn('delayed_status', function ($row) {
                if ($row->getIsDelayedAttribute()) {
                    return "<span class='badge bg-danger text-white'>Delayed</span>";
                } else {
                    return "<span class='badge bg-danger text-white'>On Time</span>";
                }
            })
            ->rawColumns(['verification_status', 'storage_status', 'action', 'submission_status'])
            ->filterColumn('submission_status', function (Builder $row) use ($request) {
                switch (Str::lower($request->get('search')['value'])) {
                    case 'delayed':
                        if ($row->delayed()) {
                            return true;
                        }
                        break;
                    case 'on time':
                        if ($row->onTime()) {
                            return true;
                        }
                        break;
                }

                return false;
            })
            ->filterColumn('verification_status', function (Builder $row) use ($request) {
                switch (Str::lower($request->get('search')['value'])) {
                    case 'approved':
                        if ($row->whereNotNull('approved_at')) {
                            return true;
                        }
                        break;
                    case 'pending':
                        if ($row->whereNull('approved_at')) {
                            return true;
                        }
                        break;
                }

                return false;
            })
            ->filterColumn('storage_status', function (Builder $row) use ($request) {
                switch (Str::lower($request->get('search')['value'])) {
                    case 'current':
                        if ($row->whereNull('deleted_at')->whereNull('archived_at')) {
                            return true;
                        }
                        break;
                    case 'archived':
                        if ($row->whereNull('deleted_at')->whereNotNull('archived_at')) {
                            return true;
                        }
                        break;
                    case 'trashed':
                        if ($row->whereNotNull('deleted_at')) {
                            return true;
                        }
                        break;
                }

                return false;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y-m-d H:i:s');
            })
            ->editColumn('deleted_at', function ($data) {
                return $data->deleted_at ? $data->deleted_at->format('Y-m-d H:i:s') : '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Resource $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Resource $model)
    {
        $startDate = !empty(request()->get('start_date')) ? Carbon::make(request()->get('start_date'))->endOfDay() : now()->subYear(1)->endOfDay();
        $endDate = !empty(request()->get('end_date')) ? Carbon::make(request()->get('end_date'))->endOfDay() : now()->endOfDay();
        $yearLevel = request()->get('year_level') ? [request()->get('year_level')] : [1, 2, 3, 4];
        $semester = request()->get('semester') ? [request()->get('semester')] : [1, 2, 3];
        $term = request()->get('term') ? [request()->get('term')] : [1, 2];

        $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))
            ->whereIn('year_level', $yearLevel)
            ->whereIn('semester', $semester)
            ->whereIn('term', $term)
            ->orderBy('title')
            ->get();
        $course = request()->get('course') ? [request()->get('course')] : $courses->pluck('id');

        return $model::select('resources.*')->whereHas('course', function (Builder $query) use ($yearLevel, $semester, $term, $course) {
            return $query
                ->whereIn('program_id', auth()->user()->programs->pluck('id'))
                ->whereIn('year_level', $yearLevel)
                ->whereIn('semester', $semester)
                ->whereIn('term', $term)
                ->whereIn('id', $course);
        })
            ->with(['media', 'course', 'lesson', 'user'])
            ->where('is_syllabus', true)
            ->whereBetween('resources.created_at', [$startDate, $endDate]);
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
            Column::make('title'),
            Column::make('current_media', 'media.file_name'),
            Column::make('description'),
            Column::make('submission_status'),
            Column::make('submitter', 'user.fname'),
            Column::make('created_at'),
            Column::make('course', 'course.title'),
            Column::make('lesson', 'lesson.title')->orderable(FALSE),
            Column::make('versions')->searchable(false),
            Column::make('verification_status'),
            Column::make('storage_status'),
            Column::make('views'),
            Column::make('downloads'),
            Column::make('updated_at'),
            Column::make('archived_at'),
            Column::make('deleted_at'),
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
        return 'SyllabusReports_' . date('YmdHis');
    }
}
