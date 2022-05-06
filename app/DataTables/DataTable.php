<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable as YajraDataTable;

class DataTable extends YajraDataTable
{
    protected $tableDom = 'plfrtipl';
    protected $tableDomWithButton = 'Bplfrtipl';

    protected function sharedBuilder($withBtn = false, $withCreate = true, $order = 'desc')
    {
        $builder = $this->builder()
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
            ->dom($withBtn ? $this->tableDomWithButton : $this->tableDom);

        if ($withCreate) {
            $builder = $builder->buttons(
                Button::make(['extend' => 'create', 'className' => 'btn btn-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make(['extend' => 'export', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make(['extend' => 'print', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make([
                    'extend' => 'reset',

                    'className' => 'border btn text-primary',
                    'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}'
                ]),
                Button::make(['extend' => 'reload', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
            );
        } else {
            $builder = $builder->buttons(
                Button::make(['extend' => 'export', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make(['extend' => 'print', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
                Button::make([
                    'extend' => 'reset',

                    'className' => 'border btn text-primary',
                    'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}'
                ]),
                Button::make(['extend' => 'reload', 'className' => 'border btn text-primary', 'init' => 'function(api, node, config) {$(node).removeClass("btn-secondary")}']),
            );
        }

        return $builder;
    }

    protected function sharedActions($row, $viewRoute, $editRoute, $archiveRoute, $trashRoute)
    {
        $btn = '<div class="d-flex gap-2">';
        $btn .= '<a href="' . $viewRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';

        if ($row->storage_status == 'Trashed') {
            $trashTitle = 'Restore';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="restore" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        } else if ($row->storage_status == 'Archived') {
            $btn .= '<a href="' . $editRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
            $archiveTitle = 'Unarchive';
            $trashTitle = 'Trash';
            $btn .= '<a  data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $archiveRoute . '" data-bs-operation="unarchive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        } else if ($row->storage_status == 'Current') {
            $btn .= '<a href="' . $editRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
            $archiveTitle = 'Archive';
            $trashTitle = 'Trash';

            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $archiveRoute . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        }

        $btn .= '</div>';

        return $btn;
    }

    protected function sharedWithoutEditActions($row, $viewRoute, $archiveRoute, $trashRoute)
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
        } else if ($row->storage_status == 'Current') {
            $archiveTitle = 'Archive';
            $trashTitle = 'Trash';

            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $archiveRoute . '" data-bs-operation="archive" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-warning border fw-bold">' . $archiveTitle . '</a>';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="trash" data-bs-title="' . $row->title . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        }

        $btn .= '</div>';

        return $btn;
    }

    protected function sharedWithoutViewActions($row, $editRoute, $trashRoute, $subjectLabel)
    {
        $btn = '<div class="d-flex gap-2">';
        if ($row->trashed()) {
            $trashTitle = 'Restore';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="restore" data-bs-title="' . $subjectLabel . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        } else {
            $trashTitle = 'Trash';
            $btn .= '<a href="' . $editRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="trash" data-bs-title="' . $subjectLabel . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        }

        $btn .= '</div>';

        return $btn;
    }

    protected function sharedWithoutArchivedActions($row, $viewRoute, $editRoute, $trashRoute, $subjectLabel)
    {
        $btn = '<div class="d-flex gap-2">';
        if ($row->trashed()) {
            $trashTitle = 'Restore';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="restore" data-bs-title="' . $subjectLabel . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        } else {
            $trashTitle = 'Trash';
            $btn .= '<a href="' . $viewRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
            $btn .= '<a href="' . $editRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
            $btn .= '<a data-bs-toggle="modal" data-bs-target="#modalManagement" data-bs-route="' . $trashRoute . '" data-bs-operation="trash" data-bs-title="' . $subjectLabel . '" class="btn btn-sm btn-light text-danger border fw-bold">' . $trashTitle . '</a>';
        }

        $btn .= '</div>';

        return $btn;
    }

    protected function sharedViewOnlyActions($row, $viewRoute)
    {
        $btn = '<div class="d-flex gap-2">';
        $btn .= '<a href="' . $viewRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';

        $btn .= '</div>';

        return $btn;
    }

    protected function sharedViewAndEditOnlyActions($row, $viewRoute, $editRoute)
    {
        $btn = '<div class="d-flex gap-2">';
        $btn .= '<a href="' . $viewRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
        $btn .= '<a href="' . $editRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">Edit</a>';
        $btn .= '</div>';

        return $btn;
    }

    protected function sharedResourceActions($row, $viewRoute, $previewRoute, $downloadRoute)
    {
        $btn = '<div class="d-flex gap-2">';
        $btn .= '<a href="' . $viewRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">View</a>';
        $btn .= '<a href="' . $previewRoute . '" class="btn btn-sm btn-light text-primary border fw-bold">Preview</a>';
        $btn .= '<form action="' . $downloadRoute . '" method="POST">';
        $btn .= csrf_field();
        $btn .= '<button type="submit" class="btn btn-sm btn-primary fw-bold border">Download</button>';
        $btn .= '</form>';
        $btn .= '</div>';

        return $btn;
    }

    protected function modelStoreType($model, $excepts = [])
    {
        $excepts = collect($excepts);

        $storeType = request()->get('storeType') ?? null;

        if ($storeType == 'archived') {
            $model = $model->onlyArchived();
        } else if ($storeType == 'trashed') {
            $model = $model->onlyTrashed();
        } else {
            if ($excepts->contains('archived')) {
                $model = $model;
            } else {
                $model = $model->withoutArchived();
            }
        }

        return $model;
    }
}
