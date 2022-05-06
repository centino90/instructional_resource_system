<?php

namespace App\DataTables\Management\Dean;

use App\DataTables\DataTable;
use App\Models\Course;
use App\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class CoursesDataTable extends DataTable
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
            ->addColumn('program', function ($row) {
                return $row->program->code;
            })
            ->addColumn('assigned_instructors', function ($row) {
                return implode(', ', $row->instructors()->wherePivot('view', true)->get()->pluck('name')->toArray());
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->editColumn('archived_at', function ($row) {
                return $row->archived_at;
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at;
            })
            ->addColumn('trashed_at', function ($row) {
                return $row->deleted_at;
            })
            ->addColumn('action', function ($row) {
                return $this->sharedActions(
                    $row,
                    route('course.show', $row->id),
                    route('dean.course.edit', $row->id),
                    route('dean.course.archive', $row->id),
                    route('dean.course.destroy', $row->id)
                );
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Course $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $model)
    {
        $model = $model
            ->whereIn('program_id',  auth()->user()->programs->pluck('id'))
            ->with(['lessons', 'resources', 'program', 'users'])
            ->withCount('resources', 'program', 'lessons', 'users');

        return $this->modelStoreType($model);
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
            Column::make('program',),
            Column::make('year_level'),
            Column::make('semester'),
            Column::make('term'),
            Column::make('assigned_instructors')->searchable(false)->orderable(false),
            Column::make('resources_count')->searchable(false)->orderable(false),
            Column::make('lessons_count')->searchable(false)->orderable(false),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('archived_at'),
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
