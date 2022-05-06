<?php

namespace App\DataTables\Management;

use App\DataTables\DataTable;
use App\Models\Notification;
use App\Models\User;
use Yajra\DataTables\Html\Column;

class UserNotificationsDataTable extends DataTable
{
    private $userId;

    public function __construct()
    {
        $this->userId = request()->route()->parameter('user')->id;
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
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('read_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('message', function ($row) {
                return $row->data['message'];
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . $row->data["link"] . '" class="notification-show-link btn btn-light text-primary border fw-bold">View again</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Notification $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Notification $model)
    {
        return $model
            ->whereNotNull('read_at')
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $this->userId);
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
            Column::make('read_at'),
            Column::make('message'),
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
        return 'Notifications_' . date('YmdHis');
    }
}
