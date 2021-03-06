<?php

namespace App\DataTables\Course;

use App\DataTables\DataTable;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;

class LessonResourcesDataTable extends DataTable
{
    private $lessonId;
    private $lessonTitle;

    public function __construct()
    {
        $this->lessonId = request()->route()->parameter('lesson')->id;
        $this->lessonTitle = Str::kebab(request()->route()->parameter('lesson')->title);
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
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToShow', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '<a href="' . route('resource.addViewCountThenRedirectToPreview', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Preview</a>';
                $btn .= '<a href="' . route('resources.downloadOriginal', $row->currentMediaVersion) . '" class="btn btn-sm btn-primary fw-bold border">Download</a>';
                $btn .= '</div>';

                return $btn;
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
            ->whereHas('lesson')
            ->where('is_syllabus', false)
            ->where('lesson_id', $this->lessonId)
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
        return $this->lessonTitle . '_Resources_' . date('YmdHis');
    }
}
