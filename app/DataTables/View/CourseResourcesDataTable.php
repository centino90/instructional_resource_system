<?php

namespace App\DataTables\View;

use App\DataTables\DataTable;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class CourseResourcesDataTable extends DataTable
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
            ->addColumn('media', function ($row) {
                return $row->currentMediaVersion ? $row->currentMediaVersion->file_name : 'unknown file';
            })
            ->addColumn('course', function ($row) {
                return $row->course->title;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($row) {
                return $this->sharedResourceActions(
                    $row,
                    route('resource.addViewCountThenRedirectToShow', $row->id),
                    route('resource.addViewCountThenRedirectToPreview', $row->id),
                    route('resources.downloadOriginal', $row->currentMediaVersion),
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
        return $model
            ->where('course_id', $this->courseId)
            ->whereNotNull('approved_at')
            ->with(['media']);
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
        return $this->courseCode . '_Resources_' . date('YmdHis');
    }
}
