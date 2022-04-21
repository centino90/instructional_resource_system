<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CMS\ResourcesDataTable;
use App\DataTables\CoursesDataTable;
use App\DataTables\LessonsDataTable;
use App\DataTables\PersonnelDataTable;
use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use App\Models\TypologyStandard;
use Illuminate\Http\Request;

class SystemAdminController extends Controller
{

    public function index()
    {
        $settings = AdminSettings::first();

        return view('pages.admin.system.index', compact('settings'));
    }

    public function updateOldSyllabusInterval(Request $request)
    {

        $settings = AdminSettings::first();
        $settings->old_syllabus_year_interval = $request->old_syllabus_year_interval;
        $settings->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Old Syllabus Yearly Interval was updated'
        ]);
    }

    public function updateDelayedSyllabusInterval(Request $request)
    {
        $settings = AdminSettings::first();
        $settings->delayed_syllabus_week_interval = $request->delayed_syllabus_week_interval;
        $settings->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Dellayed Syllabus Weekly Interval was updated'
        ]);
    }
}
