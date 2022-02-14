@props(['semester' => '', 'courses' => []])

@php
$semesters = collect([
    [
        'key' => 1,
        'label' => 'First Semester',
    ],
    [
        'key' => 2,
        'label' => 'Second Semester',
    ],
]);
@endphp

<section class="py-4">
    <div class="row">
        <div class="col-12">
            <header class="fw-bold pb-2">{{ $semesters->firstWhere('key', $semester)['label'] }}</header>
        </div>

        <!-- FIRST TERM -->
        <div class="col-6">
            <div class="card shadow">
                <div class="card-body">
                    <header class="text-center form-text fw-bold pb-2">First Term</header>

                    <table class="table align-middle table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Action</th>
                                <th scope="col">Subject code</th>
                                <th scope="col">Subject title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses->where('semester', $semester)->where('term', 1) as $row)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-bs-courseid="{{ $row->id }}"
                                            data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                    </td>
                                    <td>{{ $row->code }}</td>
                                    <td>{{ $row->title }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3">
                                        <div class="hstack justify-content-center gap-2 text-center">
                                            <img title="alert triangle" alt="alert triangle icon" class="img-thumbnail"
                                                src="{{ asset('images/icons/alert-triangle.svg') }}" />
                                            No course available in table
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECOND TERM -->
        <div class="col-6">
            <div class="card shadow">
                <div class="card-body">
                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                    <table class="table align-middle table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Action</th>
                                <th scope="col">Subject code</th>
                                <th scope="col">Subject title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses->where('semester', $semester)->where('term', 2) as $row)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-bs-courseid="{{ $row->id }}"
                                            data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                    </td>
                                    <td>{{ $row->code }}</td>
                                    <td>{{ $row->title }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3">
                                        <div class="hstack justify-content-center gap-2 text-center">
                                            <img title="alert triangle" alt="alert triangle icon" class="img-thumbnail"
                                                src="{{ asset('images/icons/alert-triangle.svg') }}" />
                                            No course available in table
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
