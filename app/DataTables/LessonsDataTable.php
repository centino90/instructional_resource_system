<?php

namespace App\DataTables;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LessonsDataTable extends DataTable
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
            ->addColumn('course', function ($row) {
                return "{$row->course->title} ({$row->course->code})";
            })
            ->addColumn('submitter', function ($row) {
                return $row->user->name;
            })
            ->addColumn('resource_count', function ($row) {
                return $row->resources_count;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LessonsDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LessonsDataTable $model)
    {
        return $model
            ->whereHas('course', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            })
            ->with(['course', 'user', 'resources'])
            ->withCount('resources')
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
            ->parameters([
                'responsive' => true
            ])
            ->setTableId('lessons-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
            Column::make('title'),
            Column::make('description'),
            Column::make('course', 'course.title')->searchable(),
            Column::make('submitter', 'user.name')->searchable(),
            Column::make('resources_count', 'resources_count'),
            Column::make('created_at')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Lessons_' . date('YmdHis');
    }
}
