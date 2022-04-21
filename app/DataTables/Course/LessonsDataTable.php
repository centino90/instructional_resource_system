<?php

namespace App\DataTables\Course;

use App\DataTables\DataTable;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
class LessonsDataTable extends DataTable
{
    private $courseId;
    private $courseCode;

    public function __construct()
    {
        $this->courseId = request()->route()->parameter('course')->id;
        $this->courseCode = request()->route()->parameter('course')->code;
    }

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
            ->setRowId(function ($row) {
                return "subject{$row->id}";
            })
            ->addColumn('course', function ($row) {
                return "{$row->course->title}";
            })
            ->addColumn('author', function ($row) {
                return $row->user->name;
            })
            ->addColumn('storage_status', function ($row) {
                return $row->storage_status;
            })
            ->addColumn('resources_count', function ($row) {
                return $row->resources_count ?? 0;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('lesson.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '</div>';

                return $btn;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Lesson $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lesson $model)
    {
        return $model
            ->whereHas('course', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            })
            ->where('course_id', $this->courseId)
            ->with(['course', 'user', 'resources'])
            ->withCount('resources');
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
            Column::make('title'),
            Column::make('description'),
            Column::make('course', 'course.title'),
            Column::make('author', 'user.fname'),
            Column::make('resources_count'),
            Column::make('storage_status'),
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
        return $this->courseCode . '_Lessons_' . date('YmdHis');
    }
}
