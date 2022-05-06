<?php

namespace App\DataTables\Management\Dean;

use App\DataTables\DataTable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class InstructorsDataTable extends DataTable
{
    private $isGeneralDean;
    private $authProgram;

    public function __construct()
    {
        $this->isGeneralDean = request()->user()->programs()
            ->where('is_general', true)->exists();

        $this->authProgram = request()->user()->programs->first();
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
            ->addColumn('first_name', function ($row) {
                return $row->fname;
            })
            ->addColumn('last_name', function ($row) {
                return $row->lname;
            })
            ->addColumn('password', function ($row) {
                return !empty($row->temp_password) ? 'Auto Generated' : 'Updated';
            })
            ->addColumn('generated_password', function ($row) {
                return $row->temp_password;
            })
            ->addColumn('program', function ($row) {
                return $row->programs->first()->code;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($row) {
                if ($this->isGeneralDean && $row->programs->first()->id != $this->authProgram->id) {
                    return $this->sharedViewAndEditOnlyActions($row, route('user.show', $row->id), route('dean.instructor.edit', $row->id));
                } else {
                    return $this->sharedWithoutArchivedActions($row, route('user.show', $row->id), route('dean.instructor.edit', $row->id), route('dean.instructor.destroy', $row->id), $row->name);
                }
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        if ($this->isGeneralDean) {
            $model = $model->whereHas('programs');
        } else {
            $model = $model->whereHas('programs', function (Builder $query) {
                $query->whereIn('id', auth()->user()->programs->pluck('id'));
            });
        }

        $model = $model->instructors()
            ->with(['lessons', 'resources', 'activityLogs', 'courses'])
            ->withCount('resources', 'activityLogs', 'lessons', 'courses as assigned_courses');


        return $this->modelStoreType($model, ['archived']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->sharedBuilder(true)
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
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('username'),
            Column::make('password'),
            Column::make('generated_password'),
            Column::make('lessons_count'),
            Column::make('resources_count'),
            Column::make('email'),
            Column::make('contact_no'),
            Column::make('program'),
            Column::make('assigned_courses')->searchable(false)->orderable(false),
            Column::make('created_at'),
            Column::computed('action', '')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Instructors_' . date('YmdHis');
    }
}
