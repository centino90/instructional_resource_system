<?php

namespace App\DataTables\User;

use App\DataTables\DataTable;
use App\Models\Lesson;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class UserLessonsDataTable extends DataTable
{
    private $userId;

    public function __construct()
    {
        $this->userId = request()->route()->parameter('user')->id;
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
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['action'])
            ->addColumn('action', function ($row) {
                return $this->sharedActionBtns(
                    $row,
                    route('lesson.show', $row->id),
                    route('lesson.archive', $row->id),
                    route('lesson.destroy', $row->id),
                );
            });
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
            ->whereHas('course', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            })
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
            Column::make('course',),
            Column::make('submitter'),
            Column::make('resources_count'),
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
        return 'Lessons_' . date('YmdHis');
    }
}
