<?php

namespace App\DataTables;

use App\Models\Lesson;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LessonsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $accessType = request()->get('accessType');

        $dataTables = datatables()
            ->eloquent($query)
            ->editColumn('course', function ($row) {
                return "{$row->course->title} ({$row->course->code})";
            })
            ->editColumn('submitter', function ($row) {
                return $row->user->name;
            })
            ->addColumn('resources_count', function ($row) {
                return $row->resources_count;
            });

        if ($accessType == Role::PROGRAM_DEAN) {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('lesson.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '<a href="' . route('lesson.edit', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
                if ($row->storage_status == 'Trashed') {
                    $trashTitle = 'Remove';
                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('lesson.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                } else if ($row->storage_status == 'Archived') {
                    $archiveTitle = 'Remove';
                    $trashTitle = 'Trash';
                    $btn .= '<a  data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('lesson.archive', $row->id) . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('lesson.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                } elseif ($row->storage_status == 'Current') {
                    $archiveTitle = 'Archive';
                    $trashTitle = 'Trash';

                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('lesson.archive', $row->id) . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('lesson.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                }

                $btn .= '</div>';

                return $btn;
            });
        } else {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('resource.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '</div>';

                return $btn;
            });
        }
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
        $accessType = request()->get('accessType');

        $builder = $this->builder()
            ->pageLength(5)
            ->lengthMenu([5, 10, 20, 50, 100])
            ->responsive(true)
            ->setTableId('lessons-table')
            ->columns($this->getColumns())
            ->fixedColumnsLeftColumns(1)
            ->fixedColumnsRightColumns(1)
            ->minifiedAjax()
            ->selectStyleMulti()
            ->stateSave(true)
            ->stateSaveParams('function(settings, data) {
            data.search.search = ""
        }')
            ->dom('Bplfrtipl');

        if ($accessType == Role::PROGRAM_DEAN) {
            return $builder
                ->dom('Bplfrtipl')
                ->buttons(
                    Button::make(['extend' => 'export', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                    Button::make(['extend' => 'print', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                    Button::make(['extend' => 'reset', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                    Button::make(['extend' => 'reload', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                );
        } else {
            return $builder->dom('plfrtipl');
        }
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
            Column::make('course', 'course.title'),
            Column::make('submitter', 'user.fname'),
            Column::make('resources_count', 'resources_count'),
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
        return 'Lessons_' . date('YmdHis');
    }
}
