<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable as YajraDataTable;

class DataTable extends YajraDataTable
{
    protected $tableDom = 'plfrtipl';
    protected $tableDomWithButton = 'Bplfrtipl';

    protected function sharedBuilder($withBtn = false, $order = 'desc')
    {
        return $this->builder()
            ->pageLength(5)
            ->lengthMenu([5, 10, 20, 50, 100])
            ->responsive(true)
            ->orderBy(0, $order)
            ->setTableId('main-table')
            ->minifiedAjax()
            ->selectStyleMulti()
            ->stateSave(true)
            ->stateSaveParams('function(settings, data) {
            data.search.search = ""
            data.order = [[0, "' . $order . '"]]
        }')
            ->buttons(
                Button::make(['extend' => 'export', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make(['extend' => 'print', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make([
                    'extend' => 'reset',

                    'className' => 'border btn text-primary',
                    'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}'
                ]),
                Button::make(['extend' => 'reload', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
            )
            ->dom($withBtn ? $this->tableDomWithButton : $this->tableDom);
    }

    protected function sharedActionBtns($row, $viewRoute, $archiveRoute, $trashRoute)
    {
        $btn = '<div class="d-flex gap-2">';
        $btn .= '<a href="' . $viewRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
        if ($row->storage_status == 'Trashed') {
            $trashTitle = 'Restore';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="restore" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        } else if ($row->storage_status == 'Archived') {
            $archiveTitle = 'Unarchive';
            $trashTitle = 'Trash';
            $btn .= '<a  data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $archiveRoute . '" data-bs-operation="unarchive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        } elseif ($row->storage_status == 'Current') {
            $archiveTitle = 'Archive';
            $trashTitle = 'Trash';

            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $archiveRoute . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        }

        $btn .= '</div>';

        return $btn;
    }

    protected function modelStoreType($model)
    {
        $storeType = request()->get('storeType') ?? null;

        if ($storeType == 'archived') {
            $model = $model->onlyArchived();
        } else if ($storeType == 'trashed') {
            $model = $model->onlyTrashed();
        } else if ($storeType == 'all') {
            $model = $model->withTrashed();
        } else {
            $model->withoutArchived();
        }

        return $model;
    }
}
