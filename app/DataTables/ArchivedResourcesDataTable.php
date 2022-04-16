<?php

namespace App\DataTables;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ArchivedResourcesDataTable extends DataTable
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
            ->setRowId('id')
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToPreview', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Preview</a>';
                $btn .= '<a href="' . route('resources.downloadOriginal', $row->currentMediaVersion) . '" class="btn btn-sm btn-primary fw-bold border">Download</a>';
                $btn .= '</div>';
                return $btn;
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
        return $model
            ->whereHas('course', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            })
            ->whereNotNull('approved_at')
            ->onlyArchived()
            ->with(['media', 'course', 'lesson'])
            ->orderBy('resources.created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->responsive(true)
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip') // remove P
            ->orderBy(1)
            ->selectStyleMulti();
            // ->searchPanes(true)
            // ->addColumnDef([
            //     'searchPanes' => ['show' => true],
            //     'targets' => [3]
            // ]);
            // ->buttons(
            //     Button::make('searchPanes')
            // );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('title')->searchable(),
            Column::make('media')->searchable(),
            Column::make('description')->searchable(),
            Column::make('course', 'course.title')->searchable(),
            Column::make('lesson', 'lesson.title')->searchable(),
            Column::make('created_at')->searchable(),
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
        return 'ArchivedResources_' . date('YmdHis');
    }
}
