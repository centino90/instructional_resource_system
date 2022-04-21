<?php

namespace App\DataTables\Resource;

use App\DataTables\DataTable;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Html\Column;

class ActivitiesDataTable extends DataTable
{
    private $resourceId;
    private $resourceTitle;

    public function __construct()
    {
        $this->resourceId = request()->route()->parameter('resource')->id;
        $this->resourceTitle = Str::kebab(request()->route()->parameter('resource')->title);
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
        ->editColumn('created_at', function ($data) {
            return $data->created_at->diffForHumans();
        })
        ->addColumn('action', function ($row) {
            return '<a href="' . route('activities.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Lesson $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Activity $model)
    {
        return $model
        ->where('subject_id', $this->resourceId);
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
            Column::make('log_name'),
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
        return $this->resourceTitle . '_Lessons_' . date('YmdHis');
    }
}
