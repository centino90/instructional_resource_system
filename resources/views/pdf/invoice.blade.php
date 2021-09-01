<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

    <title>Document</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .mt-3 {
            margin-top: 15px;
        }

    </style>

</head>

<body>
    <center>
        <h5>COURSE SYLLABUS</h5>
    </center>
    {{-- @dd($data) --}}
    <ul>
        <li>
            <b>Course Code </b> <strong>:</strong>
            <span>{{ ucwords($data->course_code ?? ($data['course_code'] ?? '')) }}</span>
        </li>
        <li>
            <b>Course Title </b> <strong>:</strong>
            <span>{{ ucwords($data->course_title ?? ($data['course_title'] ?? '')) }}</span>
        </li>
        <li>
            <b>Credit </b> <strong>:</strong>
            <span>{{ ucwords($data->credit ?? ($data['credit'] ?? '')) }}</span>
        </li>
        <li>
            <b>Time Allotment </b> <strong>:</strong>
            <span>{{ ucwords($data->time_allotment ?? ($data['time_allotment'] ?? '')) }}</span>
        </li>
        <li>
            <b>Professor </b> <strong>:</strong>
            <span>{{ ucwords($data->professor ?? ($data['professor'] ?? '')) }}</span>
        </li>
    </ul>

    <h3>I - COURSE DESCRIPTION</h3>
    <div class="row">
        @foreach ($data->course_description['paragraphs'] ?? ($data['course_description']['paragraphs'] ?? []) as $row)
            <div class="col-12 mt-3">
                {{ ucfirst($row) }}
            </div>
        @endforeach
    </div>

    <h3>II - COURSE OUTCOMES</h3>
    <div class="row">
        @foreach ($data->course_outcomes['paragraphs'] ?? ($data['course_outcomes']['paragraphs'] ?? []) as $row)
            <div class="col-12 mt-3">
                {{ ucfirst($row) }}
            </div>
        @endforeach

        @foreach ($data->course_outcomes['lists'] ?? ($data['course_outcomes']['lists'] ?? []) as $row)
            <div class="col-12 mt-3">
                {{ $loop->iteration . '.' }} {{ ucfirst($row) }}
            </div>
        @endforeach
    </div>

    <h3>III - LEARNING OUTCOMES</h3>
    <div class="row">
        @foreach ($data->learning_outcomes['paragraphs'] ?? ($data['learning_outcomes']['paragraphs'] ?? []) as $row)
            <div class="col-12 mt-3">
                {{ ucfirst($row) }}
            </div>
        @endforeach

        @foreach ($data->learning_outcomes['lists'] ?? ($data['learning_outcomes']['lists'] ?? []) as $row)
            <div class="col-12 mt-3">
                {{ $loop->iteration . '.' }} {{ ucfirst($row) }}
            </div>
        @endforeach
    </div>

    <div class="page-break"></div>
    <h1>Page 2</h1>
</body>

</html>
