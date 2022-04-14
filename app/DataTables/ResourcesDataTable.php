<?php

namespace App\DataTables;

use App\Models\Course;
use App\Models\Resource;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\ColumnDefinition;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\Services\DataTable;

class ResourcesDataTable extends DataTable
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
            ->addColumn('course', function ($row) {
                return "{$row->course->title} ({$row->course->code})";
            })
            ->addColumn('lesson', function ($row) {
                return $row->lesson ? $row->lesson->title : '';
            })
            ->addColumn('media', function ($row) {
                return $row->currentMediaVersion ? $row->currentMediaVersion->file_name : 'unknown file';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y-m-d H:i:s');
            })
            ->editColumn('trashed_at', function ($data) {
                return $data->deleted_at ? $data->deleted_at->format('Y-m-d H:i:s') : '';
            });

        if ($accessType == Role::PROGRAM_DEAN) {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';

                if ($row->storage_status == 'Trashed') {
                    $trashTitle = 'Remove';
                    $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('resource.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                } else if ($row->storage_status == 'Archived') {
                    $archiveTitle = 'Remove';
                    $trashTitle = 'Trash';
                    $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('resource.toggleArchiveState', $row->id) . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
                    $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('resource.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                } elseif ($row->storage_status == 'Current') {
                    $archiveTitle = 'Archive';
                    $trashTitle = 'Trash';

                    $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('resource.toggleArchiveState', $row->id) . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
                    $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('resource.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                }

                $btn .= '</div>';

                return $btn;
            });
        } else {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToPreview', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Preview</a>';
                $btn .= '<a href="' . route('resources.downloadOriginal', $row->currentMediaVersion) . '" class="btn btn-sm btn-primary fw-bold border">Download</a>';
                $btn .= '</div>';

                return $btn;
            });
        }
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Resource $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Resource $model)
    {
        $model = $model
            ->whereHas('course', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            })
            ->whereNotNull('approved_at')
            ->with(['media', 'course', 'lesson']);

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
            ->setTableId('resources-table')
            ->columns($this->getColumns())
            ->fixedColumnsLeftColumns(1)
            ->fixedColumnsRightColumns(1)
            ->minifiedAjax()
            ->selectStyleMulti()
            ->stateSave(true)
            ->stateSaveParams('function(settings, data) {
            data.search.search = ""
        }');

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
            Column::make('media'),
            Column::make('description'),
            Column::make('course', 'course.title'),
            Column::make('lesson', 'lesson.title'),
            Column::make('created_at'),
            Column::make('approved_at'),
            Column::make('updated_at'),
            Column::make('archived_at'),
            Column::make('trashed_at', 'deleted_at'),
            Column::computed('action', '')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    // public function ajax()
    // {
    //     return $this->datatables
    //         ->eloquent($this->query())
    //         ->make(true);
    // }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Resources_' . date('YmdHis');
    }
}
