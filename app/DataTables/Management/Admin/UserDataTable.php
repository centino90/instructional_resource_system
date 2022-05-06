<?php

namespace App\DataTables\Management\Admin;

use App\DataTables\DataTable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $searchVal = Str::lower(request()->get('search')['value']);

        return datatables()
            ->eloquent($query)
            ->setRowId(function ($row) {
                return "subject{$row->id}";
            })
            ->addColumn('program', function ($row) {
                if ($row->programs->count() > 1) {
                    return implode(',', $row->programs->pluck('code')->all());
                } elseif ($row->programs->count() == 1) {
                    return $row->programs->first()->code;
                } else {
                    return 'No Program';
                }
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
            ->addColumn('role', function ($row) use ($searchVal) {
                return $row->role->name;
            })
            ->filterColumn('program', function ($query, $keyword) {
                $query->whereHas('programs', function ($query) use ($keyword) {
                    $query->where('code', 'LIKE', "%{$keyword}%");
                });
            })
            ->filterColumn('role', function ($query, $keyword) {
                $query->whereHas('role', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->format('Y-m-d H:i:s');
            })
            ->addColumn('trashed_at', function ($row) {
                return $row->deleted_at;
            })
            ->addColumn('action', function ($row) {
                return $this->sharedWithoutArchivedActions(
                    $row,
                    route('user.show', $row->id),
                    route('admin.users.edit', $row->id),
                    route('admin.users.destroy', $row->id),
                    $row->fname
                );
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
        $model = $model
            ->with(['lessons', 'resources', 'programs', 'courses'])
            ->withCount('lessons', 'resources', 'courses');

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
            Column::make('id'),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('role'),
            Column::make('username'),
            Column::make('password'),
            Column::make('generated_password'),
            Column::make('lessons_count'),
            Column::make('resources_count'),
            Column::make('email'),
            Column::make('contact_no'),
            Column::make('program'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('trashed_at'),
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
        return 'Courses_' . date('YmdHis');
    }
}
