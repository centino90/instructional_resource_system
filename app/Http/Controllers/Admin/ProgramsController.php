<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Models\Course;
use App\Models\Program;
use App\Models\Resource;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDomInterface;
use voku\helper\SimpleHtmlDomNode;
use voku\helper\SimpleHtmlDomNodeInterface;

use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

use PhpOffice\PhpWord;
use PhpOffice\PhpWord\IOFactory;

use NcJoes\OfficeConverter\OfficeConverter;

class ProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // phpword
        $resp = 'testSet2.docx';
        $docxPath = storage_path('app/public/') . $resp;

        // load word file
        $phpWord = IOFactory::load($docxPath);
        $section = $phpWord->addSection();

        $filename = explode('.', $resp);
        $origname = $filename[0];
        $source = storage_path('app/public/') . $origname . '.html';

        // Saving the doc as html
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $html = $objWriter->getContent($source);

        // dd($html);
        $cognitive = ['REMEMBER', 'UNDERSTAND', 'APPLY', 'ANALYZE', 'EVALUATE', 'CREATE'];
        $psychomotor = ['PERCEIVE', 'SET', 'RESPOND AS GUIDED', 'ACT', 'RESPOND OVERTLY', 'ADAPT', 'ORGANIZE'];
        $affective = ['RECEIVE', 'RESPOND', 'VALUE', 'ORGANIZE', 'INTERNALIZE', 'CHARACTERIZE'];

        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">';
        echo $html;
        echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
        ';
        echo '<script>';
        echo 'let arr = ' . json_encode($cognitive);
        echo '; $("body").prepend(`<div class="w-full h-full sticky-top bg-white" id="wrapper"></div>`);';
        echo '$("#wrapper").append(`<div class="container overflow-auto h-100 py-5 my-5" id="report"></div>`);';
        echo '$("#report").append(`<ul class="list-group" id=courseOutcomes><h1>Course outcomes verb checking</h1></ul>`);';
        echo '$("#report").append(`<ul class="list-group mt-5" id=studentOutcomes><h1>Student learning outcomes verb checking</h1></ul>`);';
        echo '$("#report").append(`<div class="mt-5" id="result_msg"><h5>% Result summary</h5></div>`);';
        echo '$("#report").append(`<form action="' . route('admin.resources.store') . '" method="POST" id="form" class="my-5">
        <input name="_token" value="' . csrf_token() . '" type="hidden" class="btn btn-lg btn-success mb-3"></input>
        <input type="submit" id="submit" value="Submit to proceed" disabled class="btn btn-lg btn-success mb-3"></input>
        <p>Note: You cannot submit to proceed if the system finds inapproriate verb (colored with red) in the course outcomes and student learning outcomes.</p>
        </form>`);';
        echo '

        $("body").addClass("overflow-hidden");

        let failedCourseOutcomesCounter = 0;
        let successCourseOutcomesCounter = 0;
        // Course outcomes
        $("table:eq(1)").find("td:nth-child(2)").each(function(index, element) {
            let txtContent = element.textContent.trim();
            let firstWord = txtContent.split(" ")[0].trim();
            let withoutFirstWord = txtContent.replace(firstWord, "").trim();

            let d = "";
            if($.inArray(firstWord.toUpperCase(), arr) == -1) {
                d += `<li class="list-group-item"> <b class="badge badge-success badge-pill align-middle mr-2">✓</b> ${txtContent}</li>`;
                successCourseOutcomesCounter++;
            } else {
                d += `<li class="list-group-item bg-danger text-white"> <b><u>${firstWord}</u></b> ${withoutFirstWord} </li>`;
                failedCourseOutcomesCounter++;
            }

            $("#courseOutcomes").append(d);
        })

        let failedStudentOutcomesCounter = 0;
        let successStudentOutcomesCounter = 0;

        // Student learning outcomes
        $("table:eq(3)").find("td:nth-child(1)").each(function(index, element) {
            let txtContent = element.textContent.trim();
            let firstWord = txtContent.split(" ")[0].trim();
            let withoutFirstWord = txtContent.replace(firstWord, "").trim();

            let d = "";
            if($.inArray(firstWord.toUpperCase(), arr) == -1) {
                d += `<li class="list-group-item"> <b class="badge badge-success badge-pill align-middle mr-2">✓</b> ${txtContent} </li>`;
                successStudentOutcomesCounter++;
            } else {
                d += `<li class="list-group-item bg-danger text-white"> <b><u>${firstWord}</u></b> ${withoutFirstWord} </li>`;
                failedStudentOutcomesCounter++;
            }
            $("#studentOutcomes").append(d);
        })

        let totalFailedCounter = failedCourseOutcomesCounter + failedStudentOutcomesCounter;
        let totalSuccessCounter = successCourseOutcomesCounter + successStudentOutcomesCounter;

        $("#result_msg").append(`
        <table class="table">
            <tbody>
                <tr>
                    <td></td>
                    <td class="text-center"><b>Not appropriate</b></td>
                    <td class="text-center"><b>Appropriate</b></td>
                </tr>

                <tr>
                    <td>Course outcomes</td>
                    <td class="text-center">${failedCourseOutcomesCounter}</td>
                    <td class="text-center">${successCourseOutcomesCounter}</td>
                </tr>

                <tr>
                    <td>Student learning outcomes</td>
                    <td class="text-center">${failedStudentOutcomesCounter}</td>
                    <td class="text-center">${successStudentOutcomesCounter}</td>
                </tr>


                <tr>
                    <td></td>
                    <td class="text-center"><b>Total: ${totalFailedCounter}</b></td>
                    <td class="text-center"><b>Total: ${totalSuccessCounter}</b></td>
                </tr>
            </tbody>
        </table>
        `);

        if(totalFailedCounter <= 0) {
            $("#submit").attr("disabled", false);
        } else {
            $("#submit").attr("disabled", false);
        }
        ';
        echo '</script>';

        // $document = new Dom;
        // $document->loadStr($html);
        // $document->setOptions(
        //     // this is set as the global option level.
        //     (new Options())
        //         ->setRemoveStyles(true)
        // );
        // // echo $document;
        // // exit();

        // foreach ($this->find_contains($document, 'td', 'COURSE TITLE') as $child_dom) {

        //     echo $document;
        // }

        // exit();

        // // libre office
        // // $converter = new OfficeConverter(storage_path('app/public/testSet2.docx'));
        // // dd($converter);
        // // $converter->convertTo('output-file.pdf');
        // // $converter->convertTo('output-file.html'); //generates html file in same directory as test-file.docx

        // // die('yes');

        // // 'pdftohtml_path' => 'C:\Users\AJ\Documents\GitHub\instructional_resource_system\poppler-21.11.0-h24fffdf_0\Library\bin\pdftohtml.exe',
        // // 'pdfinfo_path' => 'C:\Users\AJ\Documents\GitHub\instructional_resource_system\poppler-21.11.0-h24fffdf_0\Library\bin\pdfinfo.exe'
        // $pdf = new \TonchikTm\PdfToHtml\Pdf(storage_path('app/public/testSet1.pdf'), [
        //     'pdftohtml_path' => 'C:\Users\AJ\Documents\GitHub\instructional_resource_system\poppler-0.68.0\bin\pdftohtml.exe',
        //     'pdfinfo_path' => 'C:\Users\AJ\Documents\GitHub\instructional_resource_system\poppler-0.68.0\bin\pdfinfo.exe'
        // ]);
        // // get pdf info
        // $pdfInfo = $pdf->getInfo();
        // // dd($pdf->countPages());
        // // get count pages
        // $countPages = $pdf->countPages();
        // // get content from one page
        // $pages = $pdf->getHtml()->getAllPages();
        // // dd($contentFirstPage->getPage(1));
        // // dd($pdf->getHtml()->getAllPages()[1]);
        // $borderReached = false;
        // foreach ($pages as $index => $page) {

        //     // if ($index >= 6) {
        //     // $document = new \voku\helper\HtmlDomParser($page);
        //     $document = new Dom;
        //     $document->setOptions(
        //         // this is set as the global option level.
        //         (new Options())
        //             ->setRemoveStyles(true)
        //     );
        //     $document->loadStr($page);
        //     foreach ($document->find('p') as $e) {
        //         if (stripos($e->innerHTML(), 'Course Content') !== false) {
        //             $borderReached = true;
        //         }
        //     }

        //     if ($borderReached) {
        //         foreach ($this->find_contains($document, 'p', 'TITLE') as $child_dom) {
        //         }

        //         echo $document;
        //     }
        //     // }
        //     // dd($index);


        // }
        // // get content from all pages and loop for they
        // // foreach ($pdf->getHtml()->getAllPages() as $page) {
        // //     echo $page . '<br/>';
        // // }

    }

    public function list()
    {
        return view('pages.admin.list-programs')
            ->with('current_route', __function__)
            ->with('programs', Program::all());
    }

    // /**
    //  * @param \voku\helper\HtmlDomParser $dom
    //  * @param string                     $selector
    //  * @param string                     $keyword
    //  *
    //  * @return SimpleHtmlDomInterface[]|SimpleHtmlDomNodeInterface<SimpleHtmlDomInterface>
    //  */
    function find_contains(
        $dom,
        string $selector,
        string $keyword
    ) {
        // init
        // dd($dom->find($selector));
        $arr = collect(['REMEMBER', 'UNDERSTAND', 'APPLY', 'ANALYZE', 'CREATE', 'EVALUATE', 'BUILD']);
        $elements = new SimpleHtmlDomNode();
        foreach ($dom->find($selector) as $e) {;
            foreach ($arr as $standard) {
                if (stripos($e->innerHTML(), $standard) !== false) {
                    // dd($e->text());
                    $elements[] = $e;

                    // $e->style = $e->style . 'background-color: red;color:white;';

                    // if (Str::contains($e->text(), 'Build')) {
                    //     $e->setAttribute('style', $e->getAttribute('style') . ' color: white; background-color: red;');
                    // }
                    // if (Str::words($e->text(), 1, '') == 'Build') {
                    //     // dd($e);

                    //     // $e->firstChild()->setText('dog');
                    // }
                    $e->setAttribute('style', $e->getAttribute('style') . ' color: white; background-color: red;');
                    $e->setAttribute('class', 'red-tagged');
                }
            }
        }

        return $elements;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.create-program');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgramRequest $request)
    {
        $program = Program::create($request->validated());
        $globalPersonnels = User::whereIn('role_id', [Role::ADMIN, Role::SECRETARY])->get();
        foreach ($globalPersonnels as $personnel) {
            $personnel->programs()->attach($program->id);
        }

        return redirect()
            ->route('admin.programs.list')
            ->with('success', $program->title . ' was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program = Program::with('courses')->findOrFail($id);
        $courses = $program->courses()->with('resources')->orderBy('title')->get();

        $resources = Resource::whereIn('course_id', collect($courses)->pluck('id'))->get();
        $arr = collect();
        foreach ($resources as $resource) {
            $resource->month = Carbon::parse($resource->approved_at)->format('M');
            $resource->year = Carbon::parse($resource->approved_at)->format('Y');
            $arr->push($resource);
        }
        $resourcesByYear = $arr->groupBy('year');
        $currentYear = Carbon::parse(now())->format('Y');
        $resourcesThisYear = $resourcesByYear[$currentYear] ?? [];

        // $months = collect([
        //     "Jan" => 0, "Feb" => 0, "Mar" => 0, "Apr" => 0, "May" => 0, "Jun" => 0, "Jul" => 0, "Aug" => 0, "Sep" => 0, "Oct" => 0, "Nov" => 0, "Dec" => 0
        // ]);
        $months = collect([
            "Jan" => 0, "Feb" => 0, "Mar" => 0, "Apr" => 0, "May" => 0, "Jun" => 0, "Jul" => 0, "Aug" => 0, "Sep" => 0, "Oct" => 0, "Nov" => 0, "Dec" => 0
        ]);
        foreach ($resourcesThisYear as $resource) {
            foreach ($months as $month => $value) {
                if ($month == Carbon::parse($resource->approved_at)->format('M')) {
                    $months[$month] = $months[$month] + 1;
                }
            }
        };
        // dd($months);


        // $months = collect([
        //     "Jan" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Feb" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Mar" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Apr" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "May" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Jun" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Jul" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Aug" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Sep" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Oct" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Nov" => ['uploads' => 0, 'downloads' => 0, 'views' => 0],
        //     "Dec" => ['uploads' => 0, 'downloads' => 0, 'views' => 0]
        // ]);
        // foreach ($resourcesThisYear as $resource) {
        //     foreach ($months as $month => $value) {
        //         if ($month == Carbon::parse($resource->approved_at)->format('M')) {
        //             dd($value);
        //             $metrics = collect($value);
        //             $months[$month] = $metrics->put('downloads', $resource->downloads)->all();

        //             dd($months[$month]);
        //         }
        //     }
        // };
        // dd($months);

        $instructors = Program::find($id)->users()->where('role_id', Role::INSTRUCTOR)->get();

        return view('pages.admin.show-program')
            ->with('program', $program)
            ->with('courses', $courses)
            ->with('instructors', $instructors)
            ->with('year', $currentYear)
            ->with('months', $months->values())
            ->with('totalUploads', $resources->count())
            ->with('totalCourses', $courses->count())
            ->with('totalInstructors', $instructors->count());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.admin.edit-program')->with('program', Program::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProgramRequest $request, $id)
    {
        Program::findOrFail($id)->update($request->validated());

        return redirect()
            ->route('admin.programs.list')
            ->with('success', 'a program was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $globalPersonnels = User::whereIn('role_id', [Role::ADMIN, Role::SECRETARY])->get();
        foreach ($globalPersonnels as $personnel) {
            $personnel->programs()->detach($program->id);
        }
        $program->delete();

        return redirect()
            ->route('admin.programs.list')
            ->with('success', $program->title . ' was deleted successfully');
    }
}
