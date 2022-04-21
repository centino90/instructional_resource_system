<?php

namespace App\DataTables\CMS;

use App\DataTables\DataTable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class PersonnelDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $accessType = request()->get('accessType');

        $dataTables = datatables()
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
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('program', function ($row) {
                return $row->programs->first()->code;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['action']);

        if ($accessType == Role::PROGRAM_DEAN) {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('user.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '<a href="' . route('user.edit', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
                if ($row->trashed() == 'Trashed') {
                    $trashTitle = 'Remove';
                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('user.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                } else {
                    $trashTitle = 'Trash';

                    $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . route('user.destroy', $row->id) . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
                }

                $btn .= '</div>';

                return $btn;
            });
        } else {
            return $dataTables->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('resource.show', $row->id) . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
                $btn .= '</div>';

                return $btn;
            });
        }
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $model = $model
            ->whereHas('programs', function (Builder $query) {
                $query->whereIn('id', auth()->user()->programs->pluck('id'));
            })
            ->instructors()
            ->with(['lessons', 'resources', 'activityLogs'])
            ->withCount('resources', 'activityLogs', 'lessons');

        if ($this->storeType == 'trashed') {
            return $model->onlyTrashed();
        } else if ($this->storeType == 'all') {
            return $model->withTrashed();
        } {
            return $model;
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $this->sharedBuilder()->columns($this->getColumns());
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
            Column::make('email',),
            Column::make('program'),
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
        return 'Personnel_' . date('YmdHis');
    }
}
