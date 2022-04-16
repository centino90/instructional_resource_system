<?php

namespace App\Http\Controllers\ProgramDean;

use App\DataTables\CoursesDataTable;
use App\DataTables\LessonsDataTable;
use App\DataTables\PersonnelDataTable;
use App\DataTables\ResourcesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\TypologyStandard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContentManagementController extends Controller
{

    public function watermarks()
    {
    }
    public function typology()
    {
        $typology = TypologyStandard::first();

        return view('pages.dean.cms-typology', compact('typology'));
    }
    public function lessons(LessonsDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.cms-lessons');
    }
    public function courses(CoursesDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.cms-courses');
    }
    public function personnels(PersonnelDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.cms-personnels');
    }
    public function resources(ResourcesDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.resources.index');
    }
}
