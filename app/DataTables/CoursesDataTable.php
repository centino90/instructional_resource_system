<?php

namespace App\DataTables;

use App\Models\Course;
use App\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

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
        $accessType = request()->get('accessType');

        $dataTables = datatables()
            ->eloquent($query)
            ->setRowId(function ($row) {
                return "subject{$row->id}";
            })
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('code', function ($row) {
                return $row->code;
            })
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->addColumn('program', function ($row) {
                return $row->program->code;
            })
            ->addColumn('year_level', function ($row) {
                return $row->year_level;
            })
            ->addColumn('semester', function ($row) {
                return $row->semester;
            })
            ->addColumn('term', function ($row) {
                return $row->term;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('archived_at', function ($row) {
                return $row->archived_at;
            })
            ->addColumn('updated_at', function ($row) {
                return $row->updated_at;
            })
            ->addColumn('trashed_at', function ($row) {
                return $row->deleted_at;
            })
            ->rawColumns(['action']);

        if ($accessType == Role::PROGRAM_DEAN) {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('course.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '<a href="' . route('course.edit', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
                if ($row->storage_status == 'Trashed') {
                    $trashTitle = 'Remove';
                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('course.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                } else if ($row->storage_status == 'Archived') {
                    $archiveTitle = 'Remove';
                    $trashTitle = 'Trash';
                    $btn .= '<a  data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('course.archive', $row->id) . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('course.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                } elseif ($row->storage_status == 'Current') {
                    $archiveTitle = 'Archive';
                    $trashTitle = 'Trash';

                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('course.archive', $row->id) . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('course.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                }

                $btn .= '</div>';

                return $btn;
            });
        } else {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('course.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '</div>';

                return $btn;
            });
        }
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
            ->with(['lessons', 'resources', 'program'])
            ->withCount('resources', 'program', 'lessons');

        if ($this->storeType == 'archived') {
            return $model->onlyArchived();
        } else if ($this->storeType == 'trashed') {
            return $model->onlyTrashed();
        } else if ($this->storeType == 'all') {
            return $model->withTrashed();
        } else {
            return $model->withoutArchived();
        }
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
            ->setTableId('courses-table')
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
            Column::make('id'),
            Column::make('code'),
            Column::make('title'),
            Column::make('program',),
            Column::make('year_level'),
            Column::make('semester'),
            Column::make('term'),
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
