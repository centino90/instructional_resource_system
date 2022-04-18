<?php

namespace App\DataTables\User;

use App\DataTables\DataTable;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class UserResourcesDataTable extends DataTable
{
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
            })->addColumn('action', function ($row) {
                return $this->sharedActionBtns(
                    $row,
                    route('resource.addViewCountThenRedirectToShow', $row->id),
                    route('resource.toggleArchiveState', $row->id),
                    route('resource.destroy', $row->id)
                );
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
        $model
            ->whereHas('course', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            })
            ->where('user_id', auth()->id())
            ->with(['media', 'course', 'lesson']);

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
            Column::make('media'),
            Column::make('description'),
            Column::make('course', 'course.title'),
            Column::make('lesson', 'lesson.title'),
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
