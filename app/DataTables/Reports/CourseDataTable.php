<?php

namespace App\DataTables\Reports;

use App\DataTables\DataTable;
use App\Models\Course;
use App\Models\Resource;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Illuminate\Support\Str;

class CourseDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $request = request();

        return datatables()
            ->eloquent($query)
            ->setRowId(function ($row) {
                return "subject{$row->id}";
            })
            ->addColumn('resource_views', function ($row) {
                return $row->resources->sum('views');
            })
            ->addColumn('resource_downloads', function ($row) {
                return $row->resources->sum('downloads');
            })
            ->addColumn('syllabus_status', function ($row) {
                if ($row->getSyllabiStatusAttribute() == 'No Syllabus') {
                    return "<span class='badge bg-danger text-white'>No Syllabus</span>";
                } else if ($row->getSyllabiStatusAttribute() == 'Old') {
                    return "<span class='badge bg-warning text-white'>Old</span>";
                } else if ($row->getSyllabiStatusAttribute() == 'Updated') {
                    return "<span class='badge bg-success text-white'>Updated</span>";
                }
            })
            ->filterColumn('syllabus_status', function ($query) use ($request) {
                switch (Str::lower($request->get('search')['value'])) {
                    case 'old':
                        if ($query->oldSyllabi()->exists()) {
                            return true;
                        }
                        break;
                    case 'updated':
                        if ($query->updatedSyllabi()->exists()) {
                            return true;
                        }
                        break;
                    case 'no syllabus':
                        if ($query->withoutSyllabi()->exists()) {
                            return true;
                        }
                        break;
                }

                return false;
            })
            ->rawColumns(['syllabus_status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Course $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $model)
    {
        $startDate = !empty(request()->get('start_date')) ? Carbon::make(request()->get('start_date'))->endOfDay() : now()->subYear(1)->endOfDay();
        $endDate = !empty(request()->get('end_date')) ? Carbon::make(request()->get('end_date'))->endOfDay() : now()->endOfDay();
        $yearLevel = request()->get('year_level') ? [request()->get('year_level')] : [1, 2, 3, 4];
        $semester = request()->get('semester') ? [request()->get('semester')] : [1, 2, 3];
        $term = request()->get('term') ? [request()->get('term')] : [1, 2];

        return $model->with([
            'resources' => fn ($query) => $query->whereBetween('created_at', [$startDate, $endDate]),
            'lessons' => fn ($query) => $query->whereBetween('created_at', [$startDate, $endDate]),
            'resources.user',
            'resources.media'
        ])
            ->withCount([
                'resources' => fn ($query) => $query->whereBetween('created_at', [$startDate, $endDate]),
                'lessons' => fn ($query) => $query->whereBetween('created_at', [$startDate, $endDate])
            ])
            ->whereIn('program_id', auth()->user()->programs->pluck('id'))
            ->whereIn('year_level', $yearLevel)
            ->whereIn('semester', $semester)
            ->whereIn('term', $term)
            ->orderBy('title');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->sharedBuilder(true, false)
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
            Column::make('resources_count')->searchable(false),
            Column::make('lessons_count')->searchable(false),
            Column::make('syllabus_status'),
            Column::make('resource_views')->searchable(false),
            Column::make('resource_downloads')->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CoursesReport' . date('YmdHis');
    }
}
