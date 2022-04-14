<?php

namespace App\Http\Controllers\ProgramDean;

use App\DataTables\LessonsDataTable;
use App\DataTables\ResourcesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContentManagementController extends Controller
{

    public function watermarks()
    {

    }
    public function typology()
    {

    }
    public function lessons()
    {

    }
    public function courses()
    {

    }
    public function personnels(LessonsDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.cms-personnels');
    }
    public function resources(ResourcesDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.resources.index');
    }
}
