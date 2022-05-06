<?php

namespace App\DataTables\Management;

use App\DataTables\DataTable;
use App\Models\Lesson;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Str;

class UserCourseLessonsDataTable extends DataTable
{
    private $courseId;
    private $userId;
    private $userName;

    public function __construct()
    {
        $this->courseId = request()->route()->parameter('course')->id;
        $this->userId = request()->route()->parameter('user')->id;
        $this->userName = Str::kebab(request()->route()->parameter('user')->name);
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
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->addColumn('description', function ($row) {
                return $row->description;
            })
            ->addColumn('course', function ($row) {
                return "{$row->course->title} ({$row->course->code})";
            })
            ->addColumn('submitter', function ($row) {
                return $row->user->name;
            })
            ->addColumn('resources_count', function ($row) {
                return $row->resources_count ?? 0;
            })
            ->addColumn('action', function ($row) {
                return $this->sharedActions($row, route('lesson.show', $row->id), route('lesson.edit', $row->id), route('lesson.archive', $row->id), route('lesson.destroy', $row->id));
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
        $model = $model
            ->where('course_id', $this->courseId)
            ->where('user_id', $this->userId)
            ->with(['course', 'user', 'resources'])
            ->withCount('resources');

        return $this->modelStoreType($model);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->sharedBuilder(false)->columns($this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('title'),
            Column::make('description'),
            Column::make('course',),
            Column::make('submitter'),
            Column::make('resources_count'),
            Column::make('created_at'),
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
        return $this->userName . '_Lessons_' . date('YmdHis');
    }
}
