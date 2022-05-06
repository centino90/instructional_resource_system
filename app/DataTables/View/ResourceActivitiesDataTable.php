<?php

namespace App\DataTables\View;

use App\DataTables\DataTable;
use App\Models\ActivityLog;
use App\Models\Resource;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;

class ResourceActivitiesDataTable extends DataTable
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
            ->editColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->editColumn('causer', function ($row) {
                return $row->causer->name;
            })
            ->addColumn('action', function ($row) {
                return $this->sharedViewOnlyActions($row, route('activities.show', $row->id));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ActivityLog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ActivityLog $model)
    {
        return $model
            ->where('subject_type', Resource::class)
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
            Column::make('causer'),
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
        return $this->resourceTitle . '_Activities_' . date('YmdHis');
    }
}
