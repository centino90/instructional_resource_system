<?php

namespace App\DataTables\View;

use App\DataTables\DataTable;
use App\Models\Resource;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class ResourceDataTable extends DataTable
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
            ->setRowId(function ($row) {
                return "subject{$row->id}";
            })
            ->editColumn('title', function ($row) {
                $description = $row->description ?? 'No Description';
                $lesson = $row->lesson ? $row->lesson->title : 'No Lesson';

                $html = "
                <div class='vstack gap-2'>
                    <div>
                        <div class='hstack gap-3'>
                            <h6 class='my-0 fw-bold'>{$row->title}</h6>
                            -
                            <i>{$row->getCurrentMediaVersionAttribute()->file_name}</i>

                            <div>•</div>

                            <div>Submitted on {$row->created_at} ({$row->created_at->diffForHumans()})</div>

                            <div >•</div>

                            <div>{$row->storage_status}</div>

                            <div >•</div>

                            <div>{$row->media->count()} version(s)</div>
                        </div>
                    </div>
                     <div class='hstack gap-3'>
                        <div>
                        <p class='text-dark m-0'>{$description}</p>
                        <small class='text-muted'>Description</small>
                        </div>

                        <div class='vr'></div>

                        <div>
                        <p class='text-dark m-0 fw-bold'>{$row->resource_type}</p>
                        <small class='text-muted'>Type</small>
                        </div>

                        <div class='vr'></div>

                        <div>
                        <p class='text-dark m-0'>{$row->course->title} ({$row->course->code})</p>
                        <small class='text-muted'>Course</small>
                        </div>

                        <div class='vr'></div>

                        <div>
                        <p class='text-dark m-0'>{$lesson}</p>
                        <small class='text-muted'>Lesson</small>
                        </div>
                    </div>
                    <div class='hstack gap-3'>
                        <div>
                            <span class='text-dark'>{$row->views} views</span>
                        </div>

                        <div>
                            <span class='text-dark'>{$row->downloads} downloads</span>
                        </div>

                        <div>
                            <span class='text-dark'>{$row->comments->count()} comments</span>
                        </div>

                        <div>•</div>

                        <div>
                        <small class='text-dark'>Last updated <span class='text-muted'>{$row->updated_at->diffForHumans()}</span></small>
                    </div>
                    </div>
                </div>
                ";

                return $html;
            })
            ->addColumn('course', function ($row) {
                return "{$row->course->title} ({$row->course->code})";
            })
            ->addColumn('type', function ($row) {
                return "{$row->resource_type}";
            })
            ->addColumn('lesson', function ($row) {
                return $row->lesson ? $row->lesson->title : '';
            })
            ->addColumn('media', function ($row) {
                return $row->currentMediaVersion ? $row->currentMediaVersion->file_name : 'unknown file';
            })
            ->addColumn('storage_status', function ($row) {
                return $row->storage_status;
            })
            ->addColumn('action', function ($row) {
                return $this->sharedResourceActions(
                    $row,
                    route('resource.addViewCountThenRedirectToShow', $row->id),
                    route('resource.addViewCountThenRedirectToPreview', $row->id),
                    route('resources.downloadOriginal', $row->currentMediaVersion)
                );
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y-m-d H:i:s');
            })
            ->editColumn('trashed_at', function ($data) {
                return $data->deleted_at ? $data->deleted_at->format('Y-m-d H:i:s') : '';
            })
            ->filterColumn('type', function ($query, $keyword) {
                switch ($keyword) {
                    case 'syllabus':
                        $query->where('is_syllabus', true);
                        break;
                    case 'presentation':
                        $query->where('is_presentation', true);
                        break;
                    case 'regular':
                        $query->where('is_syllabus', false)->where('is_presentation', false);
                        break;
                }
            })
            ->filterColumn('storage_status', function ($query, $keyword) {
                switch ($keyword) {
                    case 'current':
                        $query->whereNull('archived_at');
                        break;
                    case 'archived':
                        $query->whereNotNull('archived_at');
                        break;
                }
            })
            ->rawColumns(['action', 'title']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Resource $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Resource $model)
    {
        // programsWithGeneral
        return $model
            ->with(['media', 'course', 'lesson'])
            ->whereHas('course', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            })
            ->whereNotNull('approved_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->sharedBuilder(false, 'asc')
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
            Column::make('title'),
            Column::make('created_at')->hidden(),
            Column::make('type')->hidden(),
            Column::make('storage_status')->hidden(),
            Column::make('course', 'course.title')->hidden(),
            Column::make('lesson', 'lesson.title')->hidden(),
            Column::make('description')->hidden(),
            Column::make('media', 'media.file_name')->hidden(),

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
        return 'Resources_' . date('YmdHis');
    }
}
