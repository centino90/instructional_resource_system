<?php

namespace App\DataTables;

use App\Models\Resource;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
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
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                // ' . route('resources.show', $row->id) . '
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('resources.download', $row->id) . '" data-id="' . $row->id . '" class="btn btn-sm btn-primary">Download</a>';
                $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-secondary resource-modal-tabcontent-resource-details-tab">Details</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('media', function ($row) {
                return $row->getFirstMedia() ? $row->getFirstMedia()->name . ' (' . $row->getFirstMedia()->mime_type . ') ' : 'unknown file';
            })
            ->addColumn('date_uploaded', function ($row) {
                return Carbon::create($row->created_at)->toFormattedDateString();
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
            ->where('course_id', $this->request->course_id)
            ->whereNotNull('approved_at')
            ->with(['media', 'course'])
            ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('resources-table')
            ->columns($this->getColumns())
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60),

            Column::make('media'),
            Column::make('description'),
            Column::make('date_uploaded')->sortable(false),
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
