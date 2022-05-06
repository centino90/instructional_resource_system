<?php

namespace App\DataTables\View;

use App\DataTables\DataTable;
use App\Models\Resource;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;


class AccordionResourcesDataTable extends DataTable
{
    private $courseId;
    private $courseTitle;
    private $lessonId;

    public function __construct()
    {
        $this->courseId = request()->route()->parameter('course')->id;
        $this->courseTitle = Str::kebab(request()->route()->parameter('course')->title);
        $this->lessonId = request()->get('lesson') ?? null;
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
            ->addColumn('type', function ($row) {
                return $row->resource_type;
            })
            ->addColumn('media', function ($row) {
                return $row->currentMediaVersion ? $row->currentMediaVersion->file_name : 'unknown file';
            })
            ->addColumn('verification', function ($row) {
                return $row->getVerificationStatusAttribute();
            })
            ->addColumn('action', function ($row) {
                return $this->sharedViewOnlyActions($row, route('resource.addViewCountThenRedirectToShow', $row->id));
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
            ->where('course_id', $this->courseId)
            ->where('lesson_id', $this->lessonId)
            ->where('is_syllabus', false)
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
            Column::make('title'),
            Column::make('type'),
            Column::make('media', 'media.file_name'),
            Column::make('verification'),
            Column::make('created_at'),
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
        return $this->courseTitle . '_AccordionResources_' . date('YmdHis');
    }
}
