<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item invisible">Dashboard</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold align-middle">
                {{ __('Home') }}
            </small>
        </div>
    </x-slot>

    @if (session()->exists('status'))
        <div class="mt-4">
            <x-alert-success>
                <strong>Welcome. </strong> {{ session()->get('status') }}
            </x-alert-success>
        </div>
    @endif

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="first-year-tab" data-bs-toggle="tab" data-bs-target="#first-year"
                type="button" role="tab" aria-controls="first-year" aria-selected="true">First year</button>
            <button class="nav-link" id="nsecond-year-tab" data-bs-toggle="tab" data-bs-target="#second-year"
                type="button" role="tab" aria-controls="second-year" aria-selected="false">Second year</button>
            <button class="nav-link" id="third-year-tab" data-bs-toggle="tab" data-bs-target="#third-year"
                type="button" role="tab" aria-controls="third-year" aria-selected="false">Third year</button>
            <button class="nav-link" id="fourth-year-tab" data-bs-toggle="tab" data-bs-target="#fourth-year"
                type="button" role="tab" aria-controls="fourth-year" aria-selected="false">Fourth year</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <!-- FIRST YEAR -->
        <div class="tab-pane fade show active" id="first-year" role="tabpanel" aria-labelledby="first-year-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">First Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($firstYear as $row)
                                                @if ($row->semester == 1 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($firstYear as $row)
                                                @if ($row->semester == 1 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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

                <!-- SECOND SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">Second Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($firstYear as $row)
                                                @if ($row->semester == 2 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($firstYear as $row)
                                                @if ($row->semester == 2 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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
            </div>
        </div>

        <!-- SECOND YEAR -->
        <div class="tab-pane fade" id="second-year" role="tabpanel" aria-labelledby="second-year-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">First Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($secondYear as $row)
                                                @if ($row->semester == 1 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($secondYear as $row)
                                                @if ($row->semester == 1 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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

                <!-- SECOND SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">Second Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($secondYear as $row)
                                                @if ($row->semester == 2 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($secondYear as $row)
                                                @if ($row->semester == 2 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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
            </div>
        </div>

        <!-- THIRD YEAR -->
        <div class="tab-pane fade" id="third-year" role="tabpanel" aria-labelledby="third-year-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">First Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($thirdYear as $row)
                                                @if ($row->semester == 1 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($thirdYear as $row)
                                                @if ($row->semester == 1 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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

                <!-- SECOND SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">Second Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($thirdYear as $row)
                                                @if ($row->semester == 2 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($thirdYear as $row)
                                                @if ($row->semester == 2 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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
            </div>
        </div>

        <!-- FOURTH YEAR -->
        <div class="tab-pane fade" id="fourth-year" role="tabpanel" aria-labelledby="fourth-yea-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">First Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($fourthYear as $row)
                                                @if ($row->semester == 1 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($fourthYear as $row)
                                                @if ($row->semester == 1 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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

                <!-- SECOND SEMESTER -->
                <section class="py-4">
                    <div class="row">
                        <div class="col-12">
                            <header class="fw-bold pb-2">Second Semester</header>
                        </div>
                        <div class="col-6">
                            <!-- FIRST TERM -->
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
                                            @forelse ($fourthYear as $row)
                                                @if ($row->semester == 2 && $row->term == 1)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <!-- SECOND TERM -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <header class="text-center form-text fw-bold pb-2">Second Term</header>

                                    <table class="bg-white table align-middle table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Action</th>
                                                <th scope="col">Subject code</th>
                                                <th scope="col">Subject title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($fourthYear as $row)
                                                @if ($row->semester == 2 && $row->term == 2)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-bs-courseid="{{ $row->id }}"
                                                                data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button>
                                                        </td>
                                                        <td>{{ $row->code }}</td>
                                                        <td>{{ $row->title }}</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">No data available in table
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white border-0">
                    <DIV class="modal-title">
                        <h4 id="resource-modal-label"></h4>
                        <span>Course</span>
                    </DIV>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- MODAL NAV TABS -->
                <div class="navbar navbar-dark bg-dark px-3 py-0">
                    <ul class="w-100 nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-0" id="resource-modal-tabcontent-general-tab"
                                data-bs-toggle="pill" data-bs-target="#resource-modal-tabcontent-general" type="button"
                                role="tab" aria-controls="resource-modal-tabcontent-general"
                                aria-selected="true">General</button>
                        </li>
                        <li class="nav-item dropdown" id="submit-resource-dropdown">
                            <a class="nav-link dropdown-toggle rounded-0" data-bs-toggle="dropdown"
                                href="javascript:void(0)" role="button" aria-expanded="false">Submit resource</a>
                            <ul class="dropdown-menu shadow">
                                <li><a class="submit-resource-tab dropdown-item"
                                        id="resource-modal-tabcontent-submit-general-tab" data-bs-toggle="pill"
                                        data-bs-target="#resource-modal-tabcontent-submit-general"
                                        data-label="general" href="javascript:void(0)">General</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="submit-resource-tab dropdown-item"
                                        id="resource-modal-tabcontent-submit-syllabus-tab" data-bs-toggle="pill"
                                        data-bs-target="#resource-modal-tabcontent-submit-syllabus"
                                        data-label="syllabus" href="javascript:void(0)">Syllabus</a></li>
                                <li><a class="submit-resource-tab dropdown-item"
                                        id="resource-modal-tabcontent-submit-presentation-tab" data-bs-toggle="pill"
                                        data-bs-target="#resource-modal-tabcontent-submit-presentation"
                                        data-label="presentation"  href="javascript:void(0)">Presentation</a></li>
                            </ul>
                        </li>
                        <!-- Hidden tab -->
                        <li class="d-none nav-item" role="presentation">
                            <button class="nav-link" id="resource-modal-tabcontent-resource-details-tab"
                                data-bs-toggle="pill" data-bs-target="#resource-modal-tabcontent-resource-details"
                                type="button" role="tab" aria-selected="true">Details</button>
                        </li>
                    </ul>
                </div>
                <div class="modal-body" id="resource-modal-body">
                    <!-- MODAL TAB CONTENT-->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- GENERAL TAB -->
                        <div class="submit-resource-tabpane tab-pane fade show active"
                            id="resource-modal-tabcontent-general" role="tabpanel"
                            aria-labelledby="resource-modal-tabcontent-general-tab">
                            <div class="row g-4 mt-4">
                                <div class="col-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            Syllabus
                                        </div>

                                        <div id="course-syllabus-card" class="course-resource-card card-body text-center">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            Recent submissions
                                        </div>

                                        <div id="recent-resource-uploads-card" class="course-resource-card card-body text-center">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            Summary of uploads
                                        </div>

                                        <div id="resource-uploads-card" class="course-resource-card card-body text-center">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                          Course resources
                                        </div>

                                        <div class="card-body overflow-auto">
                                            {!! $dataTable->table(['class' => 'w-100 table table-hover']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SUBMIT GENERAL RESOURCE TAB -->
                        <div class="submit-resource-tabpane tab-pane fade"
                            id="resource-modal-tabcontent-submit-general" role="tabpanel"
                            aria-labelledby="resource-modal-tabcontent-submit-general-tab">
                            <div class="pt-4 row">
                                <div class="col-12 col-lg-4">
                                    <header class="fs-5 fw-bold">Submit Resource</header>

                                    <ul class="shadow list-group mt-3">
                                        <li class="list-group-item bg-light text-success">
                                            <header>
                                                <span> Recent submissions </span>
                                            </header>
                                            <ul id="submit-general-log"
                                                class="submit-resource-log submit-resource-logs-list submitResourceLogsList w-100 list-group mt-3">
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <!-- HIDDEN NAV TABS -->
                                    <ul class="nav nav-tabs" id="generalSubmitTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active resource-submit-form-tab" id="generalSubmitFormTab"
                                                data-bs-toggle="tab" data-bs-target="#generalSubmitForm" type="button"
                                                role="tab">Upload</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link resource-submit-preview-tab" id="generalSubmitPreviewTab"
                                                data-bs-toggle="tab" data-bs-target="#generalSubmitPreview"
                                                type="button" role="tab">Preview</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="generalSubmitTabcontent">
                                        <div class="tab-pane fade show active" id="generalSubmitForm" role="tabpanel">
                                            <div class="card rounded-0 rounded-bottom border-top-0">
                                                <!-- NAV TABS -->
                                                <header class="card-header py-0">
                                                    <ul class="nav nav-pills justify-content-end gap-3" id="pills-tab"
                                                        role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link text-dark fw-bold rounded-0 active"
                                                                id="pills-profile-tab" data-bs-toggle="pill"
                                                                data-bs-target="#pills-home" type="button"
                                                                role="tab">New file(s)</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button
                                                                class="storageUploadStandaloneBtn nav-link text-dark fw-bold rounded-0"
                                                                id="fileupload-standalone" data-bs-toggle="pill"
                                                                data-bs-target="#pills-profile" type="button"
                                                                role="tab">
                                                                Storage
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </header>
                                                <!-- DROPZONE -->
                                                <div class="card-body dropzone">
                                                    <div class="tab-content" id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="pills-home"
                                                            role="tabpanel">
                                                            <x-form-post onsubmit="event.preventDefault()"
                                                                action="{{ route('resources.store') }}"
                                                                class="submit-resource-form" id="resourceForm">
                                                                <x-input type="hidden" name="course_id"></x-input>
                                                                <div id="fileMaster">
                                                                    <div class="row-group align-items-start"
                                                                        id="file-g">
                                                                        <div class="submit-resource-form-actions"
                                                                            id="actions" class="row g-0">
                                                                            <div class="col-12">
                                                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                                                <div
                                                                                    class="d-flex align-items-start gap-2">
                                                                                    <div class="w-100 text-center">
                                                                                        <x-button
                                                                                            :class="'border btn-light fileinput-button dz-clickable w-100'"
                                                                                            style="height: 100px">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                width="24" height="24"
                                                                                                viewBox="0 0 24 24"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                class="feather feather-upload">
                                                                                                <path
                                                                                                    d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                                                <polyline
                                                                                                    points="17 8 12 3 7 8" />
                                                                                                <line x1="12" y1="3"
                                                                                                    x2="12" y2="15" />
                                                                                            </svg>
                                                                                            <span
                                                                                                class="ms-2 fs-5">Add
                                                                                                files</span>
                                                                                        </x-button>
                                                                                        <small
                                                                                            class="fw-bold form-text text-uppercase mt-2">CHOOSE
                                                                                            OR
                                                                                            DRAG YOUR FILE(s)</small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="mt-4 col-12 d-flex gap-3 flex-wrap">
                                                                                <button type="submit"
                                                                                    id="submit-resource"
                                                                                    class="btn btn-success flex-shrink-0 d-none">
                                                                                    Submit
                                                                                </button>

                                                                                <x-button
                                                                                    :class="'btn-danger cancel d-none'">
                                                                                    <span>Cancel upload</span>
                                                                                </x-button>
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <!-- The global file processing state -->
                                                                                <span class="fileupload-process w-100">
                                                                                    <div id="total-progress"
                                                                                        class="progress active w-100"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"
                                                                                        aria-valuenow="0">
                                                                                        <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                                            role="progressbar"
                                                                                            style="width: 0%;"
                                                                                            data-dz-uploadprogress="">
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                            </div>

                                                                            <div class="col-12 mt-3">
                                                                                <div class="alert alert-success fade"
                                                                                    role="alert">
                                                                                    <strong
                                                                                        class="submit-resource-alert"
                                                                                        id="submit-resource-alert"></strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="file-upload-container table-responsive overflow-auto"
                                                                            id="file-upload-container">
                                                                            <div class="table table-striped">
                                                                                <div class="d-none">
                                                                                    <div id="template"
                                                                                        class="dropzone-template file-row">
                                                                                        <!-- This is used as the file preview template -->
                                                                                        <div>
                                                                                            <span
                                                                                                class="preview"
                                                                                                style="width: 140px">
                                                                                                <img class="w-100"
                                                                                                    data-dz-thumbnail />
                                                                                            </span>
                                                                                        </div>
                                                                                        <div style="max-width: 240px">
                                                                                            <p class="name"
                                                                                                data-dz-name></p>
                                                                                            <strong
                                                                                                class="error text-danger"
                                                                                                data-dz-errormessage></strong>
                                                                                        </div>
                                                                                        <div class="file-metadata">
                                                                                            <div
                                                                                                class="row">
                                                                                                <x-input name="file[]"
                                                                                                    class="file"
                                                                                                    hidden>
                                                                                                </x-input>

                                                                                                <div
                                                                                                    class="col-12 d-none file-group">
                                                                                                    <x-label>Resource
                                                                                                        title
                                                                                                    </x-label>
                                                                                                    <x-input
                                                                                                        name="title[]">
                                                                                                    </x-input>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="col-12 d-none file-group">
                                                                                                    <x-label>Description
                                                                                                    </x-label>
                                                                                                    <x-input-textarea
                                                                                                        name="description[]">
                                                                                                    </x-input-textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="size"
                                                                                                data-dz-size></p>
                                                                                            <div class="progress progress-striped active"
                                                                                                role="progressbar"
                                                                                                aria-valuemin="0"
                                                                                                aria-valuemax="100"
                                                                                                aria-valuenow="0">
                                                                                                <div class="progress-bar progress-bar-success"
                                                                                                    style="width:0%;"
                                                                                                    data-dz-uploadprogress>
                                                                                                </div>
                                                                                            </div>
                                                                                            <span
                                                                                                class="badge bg-success">Uploaded
                                                                                                successfully</span>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-end ps-5">
                                                                                            <x-button
                                                                                                :class="'btn-primary start'">
                                                                                                <span>Start</span>
                                                                                            </x-button>

                                                                                            <x-button data-dz-remove
                                                                                                :class="'btn-warning cancel'">
                                                                                                <span>Cancel</span>
                                                                                            </x-button>

                                                                                            <x-button data-dz-remove
                                                                                                :class="'btn-danger delete'">
                                                                                                <span>Delete</span>
                                                                                            </x-button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="dropzone-preview previews"
                                                                                    id="previews"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </x-form-post>
                                                        </div>
                                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                                                            <x-form-post action="{{ route('resources.storeByUrl') }}"
                                                                id="storeByUrlForm" class="storeByUrlForm"
                                                                onsubmit="event.preventDefault()">
                                                                <div class="row">
                                                                    <x-input hidden type="url" name="fileUrl"
                                                                        id="fileUrlInput"
                                                                        class="alexusmaiFileUrlInput"></x-input>

                                                                    <div class="col-12 mt-3">
                                                                        <label class="form-text">Filename</label>
                                                                        <span
                                                                            class="alexusmaiFileText h5 text-secondary fw-bold"
                                                                            id="fileText">
                                                                        </span>
                                                                        <a href="javascript:void(0)"
                                                                            class="openStorageBtn btn btn-link"
                                                                            id="openStorageBtn">Open storage</a>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <x-label>Title</x-label>
                                                                        <x-input name="title"></x-input>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <x-label>Description</x-label>
                                                                        <x-input-textarea name="description">
                                                                        </x-input-textarea>
                                                                    </div>

                                                                    <div class="col-12 my-5">
                                                                        <button class="btn btn-success"
                                                                            type="submit">Submit</button>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="alert alert-danger fade">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </x-form-post>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- PREVIEW RESOURCE -->
                                        <div class="tab-pane fade resource-submit-preview" id="generalSubmitPreview" role="tabpanel">
                                            <div class="border border-top-0 rounded p-3 resource-submit-preview-content"
                                                id="generalSubmitPreviewContent">
                                                <div class="alert alert-warning" role="alert">
                                                    There is no file being previewed yet.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SUBMIT SYLLABUS RESOURCE TAB -->
                        <div class="submit-resource-tabpane tab-pane fade"
                            id="resource-modal-tabcontent-submit-syllabus" role="tabpanel"
                            aria-labelledby="resource-modal-tabcontent-submit-syllabus-tab">
                            <div class="pt-4 row">
                                <div class="col-12 col-lg-4">
                                    <header class="fs-5 fw-bold">Submit Syllabus</header>

                                    <ul class="shadow list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between lh-sm">
                                            <div>
                                                <h6 class="my-0 fw-bold" id="submit-syllabus-tab-status"></h6>
                                                <small class="text-muted">Status</small>
                                            </div>
                                        </li>
                                        <li
                                            class="list-group-item d-flex flex-wrap justify-content-between bg-light text-success">
                                            <span> Submit logs </span>
                                            <strong id="submit-syllabus-log-count"></strong>
                                            <ul id="submit-syllabus-log" class="submit-resource-log w-100 list-group mt-3">
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 col-lg-8">
                                    <!-- HIDDEN NAV TABS -->
                                    <ul class="nav nav-tabs" id="syllabusSubmitTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active resource-submit-form-tab" id="syllabusSubmitFormTab"
                                                data-bs-toggle="tab" data-bs-target="#syllabusSubmitForm" type="button"
                                                role="tab">Upload</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link resource-submit-preview-tab" id="syllabusSubmitPreviewTab"
                                                data-bs-toggle="tab" data-bs-target="#syllabusSubmitPreview"
                                                type="button" role="tab">Preview</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="syllabusSubmitTabcontent">
                                        <div class="tab-pane fade show active" id="syllabusSubmitForm" role="tabpanel">
                                            <div class="card rounded-0 rounded-bottom border-top-0">
                                                <!-- NAV TABS -->
                                                <header class="card-header py-0">
                                                    <ul class="nav nav-pills justify-content-end gap-3" id="pills-tab"
                                                        role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link text-dark fw-bold rounded-0 active"
                                                                id="syllabus-upload-newfile-tab" data-bs-toggle="pill"
                                                                data-bs-target="#syllabus-upload-newfile" type="button"
                                                                role="tab">New file(s)</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button
                                                                class="storageUploadStandaloneBtn nav-link text-dark fw-bold rounded-0"
                                                                id="syllabus-upload-storage-tab" data-bs-toggle="pill"
                                                                data-bs-target="#syllabus-upload-storage" type="button"
                                                                role="tab">
                                                                Storage
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </header>
                                                <!-- DROPZONE -->
                                                <div class="card-body dropzone">
                                                    <div class="tab-content" id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="syllabus-upload-newfile"
                                                            role="tabpanel">
                                                            <x-form-post onsubmit="event.preventDefault()"
                                                            action="{{ route('syllabi.upload') }}" class="submit-resource-form"
                                                            id="syllabusForm">
                                                                <x-input type="hidden" name="course_id"></x-input>
                                                                <div id="fileMaster-syllabus">
                                                                    <div class="row-group" id="file-g-syllabus">
                                                                        <div class="submit-resource-form-actions" id="actions-syllabus"
                                                                            class="row g-0">
                                                                            <div class="col-12">
                                                                                <!-- The global file processing state -->
                                                                                <span class="fileupload-process w-100">
                                                                                    <div id="total-progress-syllabus"
                                                                                        class="progress active w-100" aria-valuemin="0"
                                                                                        aria-valuemax="100" aria-valuenow="0">
                                                                                        <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                                            role="progressbar" style="width: 0%;"
                                                                                            data-dz-uploadprogress="">
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                                                <div class="d-flex align-items-start gap-2">
                                                                                    <div class="w-100 text-center">
                                                                                        <x-button
                                                                                            :class="'border btn-light fileinput-button dz-clickable w-100'"
                                                                                            style="height: 100px">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                width="24" height="24"
                                                                                                viewBox="0 0 24 24" fill="none"
                                                                                                stroke="currentColor" stroke-width="2"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                class="feather feather-upload">
                                                                                                <path
                                                                                                    d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                                                <polyline points="17 8 12 3 7 8" />
                                                                                                <line x1="12" y1="3" x2="12" y2="15" />
                                                                                            </svg>
                                                                                            <span class="ms-2 fs-5">Add
                                                                                                files</span>
                                                                                        </x-button>
                                                                                        <small
                                                                                            class="fw-bold form-text text-uppercase mt-2">CHOOSE
                                                                                            OR
                                                                                            DRAG YOUR FILE(s)</small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="mt-4 col-12 d-flex gap-3 flex-wrap"">
                                                                                <button type="submit" id="submit-resource-syllabus"
                                                                                    class="btn btn-success flex-shrink-0 d-none">Submit
                                                                                    </button>

                                                                                <x-button :class="'btn-danger cancel d-none'">
                                                                                    <span>Cancel upload</span>
                                                                                </x-button>
                                                                            </div>

                                                                            <div class="col-12 mt-3">
                                                                                <div class="alert alert-success fade" role="alert">
                                                                                    <strong class="submit-resource-alert"
                                                                                        id="submit-resource-alert-syllabus"></strong>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12 mt-3">
                                                                                <div id="syllabus-iframe-container">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="file-upload-container table-responsive overflow-auto"
                                                                            id="file-upload-container-syllabus">
                                                                            <div class="table table-striped">
                                                                                <div class="d-none">
                                                                                    <div id="template-syllabus"
                                                                                        class="dropzone-template file-row">
                                                                                        <!-- This is used as the file preview template -->
                                                                                        <div>
                                                                                            <span class="preview"><img
                                                                                                    data-dz-thumbnail /></span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="name" data-dz-name></p>
                                                                                            <strong class="error text-danger"
                                                                                                data-dz-errormessage></strong>
                                                                                        </div>
                                                                                        <div class="file-metadata">
                                                                                            <div class="row">
                                                                                                <x-input name="file[]"
                                                                                                    class="file" hidden>
                                                                                                </x-input>

                                                                                                <div class="col-12 d-none file-group">
                                                                                                    <x-label>Title</x-label>
                                                                                                    <x-input name="title[]"></x-input>
                                                                                                </div>

                                                                                                <div class="col-12 d-none file-group">
                                                                                                    <x-label>Description</x-label>
                                                                                                    <x-input-textarea
                                                                                                        name="description[]">
                                                                                                    </x-input-textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="size" data-dz-size></p>
                                                                                            <div class="progress progress-striped active"
                                                                                                role="progressbar" aria-valuemin="0"
                                                                                                aria-valuemax="100" aria-valuenow="0">
                                                                                                <div class="progress-bar progress-bar-success"
                                                                                                    style="width:0%;"
                                                                                                    data-dz-uploadprogress>
                                                                                                </div>
                                                                                            </div>
                                                                                            <span class="badge bg-success">Uploaded
                                                                                                successfully</span>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-end ps-5">
                                                                                            <x-button :class="'btn-primary start'">
                                                                                                <span>Start</span>
                                                                                            </x-button>

                                                                                            <x-button data-dz-remove
                                                                                                :class="'btn-warning cancel'">
                                                                                                <span>Cancel</span>
                                                                                            </x-button>

                                                                                            <x-button data-dz-remove
                                                                                                :class="'btn-danger delete'">
                                                                                                <span>Delete</span>
                                                                                            </x-button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="dropzone-preview previews"
                                                                                    id="previews-syllabus">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </x-form-post>
                                                        </div>
                                                        <div class="tab-pane fade" id="syllabus-upload-storage" role="tabpanel">
                                                            <x-form-post action="{{ route('syllabi.uploadByUrl') }}"
                                                                class="storeByUrlForm"
                                                                onsubmit="event.preventDefault()">
                                                                <div class="row">
                                                                    <x-input hidden type="url" name="fileUrl"
                                                                        id="fileUrlInput"
                                                                        class="alexusmaiFileUrlInput"></x-input>

                                                                    <div class="col-12 mt-3">
                                                                        <label class="form-text">Filename</label>
                                                                        <span
                                                                            class="alexusmaiFileText h5 text-secondary fw-bold"
                                                                            id="fileText">
                                                                        </span>
                                                                        <a href="javascript:void(0)"
                                                                            class="openStorageBtn btn btn-link"
                                                                            id="openStorageBtn">Open storage</a>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <x-label>Title</x-label>
                                                                        <x-input name="title"></x-input>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <x-label>Description</x-label>
                                                                        <x-input-textarea name="description">
                                                                        </x-input-textarea>
                                                                    </div>

                                                                    <div class="col-12 my-5">
                                                                        <button class="btn btn-success"
                                                                            type="submit">Submit</button>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="alert alert-danger fade">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </x-form-post>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- PREVIEW RESOURCE -->
                                        <div class="resource-submit-preview tab-pane fade" id="syllabusSubmitPreview" role="tabpanel">
                                            <div class="resource-submit-preview-content border border-top-0 rounded p-3"
                                                id="syllabusSubmitPreviewContent">
                                                <div class="alert alert-warning" role="alert">
                                                    There is no file being previewed yet.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SUBMIT PRESENTATION RESOURCE TAB -->
                        <div class="submit-resource-tabpane tab-pane fade" id="resource-modal-tabcontent-submit-presentation" role="tabpanel"
                            aria-labelledby="resource-modal-tabcontent-submit-presentation-tab">
                            <div class="pt-4 row">
                                <div class="col-12 col-lg-4">
                                    <header class="fs-5 fw-bold">Submit Presentation</header>

                                    <ul class="shadow list-group mt-3">
                                        <li
                                            class="list-group-item d-flex flex-wrap justify-content-between bg-light text-success">
                                            <span> Submit logs </span>
                                            <strong id="submit-presentation-log-count"></strong>
                                            <ul id="submit-presentation-log" class="submit-resource-log w-100 list-group mt-3">
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 col-lg-8">
                                    <!-- HIDDEN NAV TABS -->
                                    <ul class="nav nav-tabs" id="presentationSubmitTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active resource-submit-form-tab" id="presentationSubmitFormTab"
                                                data-bs-toggle="tab" data-bs-target="#presentationSubmitForm" type="button"
                                                role="tab">Upload</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link resource-submit-preview-tab" id="presentationSubmitPreviewTab"
                                                data-bs-toggle="tab" data-bs-target="#presentationSubmitPreview"
                                                type="button" role="tab">Preview</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="presentationSubmitTabcontent">
                                        <div class="tab-pane fade show active" id="presentationSubmitForm" role="tabpanel">
                                            <div class="card rounded-0 rounded-bottom border-top-0">
                                                <!-- NAV TABS -->
                                                <header class="card-header py-0">
                                                    <ul class="nav nav-pills justify-content-end gap-3" id="pills-tab"
                                                        role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link text-dark fw-bold rounded-0 active"
                                                                id="presentation-upload-newfile-tab" data-bs-toggle="pill"
                                                                data-bs-target="#presentation-upload-newfile" type="button"
                                                                role="tab">New file(s)</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button
                                                                class="storageUploadStandaloneBtn nav-link text-dark fw-bold rounded-0"
                                                                id="presentation-upload-storage-tab" data-bs-toggle="pill"
                                                                data-bs-target="#presentation-upload-storage" type="button"
                                                                role="tab">
                                                                Storage
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </header>
                                                <!-- DROPZONE -->
                                                <div class="card-body dropzone">
                                                    <div class="tab-content" id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="presentation-upload-newfile"
                                                            role="tabpanel">
                                                            <x-form-post onsubmit="event.preventDefault()"
                                                            action="{{ route('presentations.upload') }}"
                                                            class="submit-resource-form" id="presentationForm">
                                                                <x-input type="hidden" name="course_id"></x-input>
                                                                <div id="fileMaster-presentation">
                                                                    <div class="row-group" id="file-g-presentation">
                                                                        <div class="submit-resource-form-actions"
                                                                            id="actions-presentation" class="row g-0">
                                                                            <div class="col-12">
                                                                                <!-- The global file processing state -->
                                                                                <span class="fileupload-process w-100">
                                                                                    <div id="total-progress-presentation"
                                                                                        class="progress active w-100" aria-valuemin="0"
                                                                                        aria-valuemax="100" aria-valuenow="0">
                                                                                        <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                                            role="progressbar" style="width: 0%;"
                                                                                            data-dz-uploadprogress="">
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                                                <div class="d-flex align-items-start gap-2">
                                                                                    <div class="w-100 text-center">
                                                                                        <x-button
                                                                                            :class="'border btn-light fileinput-button dz-clickable w-100'"
                                                                                            style="height: 100px">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                width="24" height="24"
                                                                                                viewBox="0 0 24 24" fill="none"
                                                                                                stroke="currentColor" stroke-width="2"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                class="feather feather-upload">
                                                                                                <path
                                                                                                    d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                                                <polyline points="17 8 12 3 7 8" />
                                                                                                <line x1="12" y1="3" x2="12" y2="15" />
                                                                                            </svg>
                                                                                            <span class="ms-2 fs-5">Add
                                                                                                files</span>
                                                                                        </x-button>
                                                                                        <small
                                                                                            class="fw-bold form-text text-uppercase mt-2">CHOOSE
                                                                                            OR
                                                                                            DRAG YOUR FILE(s)</small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="mt-4 col-12 d-flex gap-3 flex-wrap"">
                                                                                <button type="submit" id="submit-resource-presentation"
                                                                                    class="btn btn-success flex-shrink-0 d-none">Submit
                                                                                    </button>

                                                                                <x-button :class="'btn-danger cancel d-none'">
                                                                                    <span>Cancel upload</span>
                                                                                </x-button>
                                                                            </div>

                                                                            <div class="col-12 mt-3">
                                                                                <div class="alert alert-success fade" role="alert">
                                                                                    <strong class="submit-resource-alert"
                                                                                        id="submit-resource-alert-presentation"></strong>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12 mt-3">
                                                                                <div id="presentation-iframe-container">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="file-upload-container table-responsive overflow-auto"
                                                                            id="file-upload-container-presentation">
                                                                            <div class="table table-striped">
                                                                                <div class="d-none">
                                                                                    <div id="template-presentation"
                                                                                        class="dropzone-template file-row">
                                                                                        <!-- This is used as the file preview template -->
                                                                                        <div>
                                                                                            <span class="preview"
                                                                                                style="max-width: 200px">
                                                                                                <img class="w-100"
                                                                                                    data-dz-thumbnail />
                                                                                            </span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="name" data-dz-name></p>
                                                                                            <strong class="error text-danger"
                                                                                                data-dz-errormessage></strong>
                                                                                        </div>
                                                                                        <div class="file-metadata">
                                                                                            <div class="row">
                                                                                                <x-input name="file[]"
                                                                                                    class="file" hidden>
                                                                                                </x-input>

                                                                                                <div class="col-12 d-none file-group">
                                                                                                    <x-label>Title</x-label>
                                                                                                    <x-input name="title[]"></x-input>
                                                                                                </div>

                                                                                                <div class="col-12 d-none file-group">
                                                                                                    <x-label>Description</x-label>
                                                                                                    <x-input-textarea
                                                                                                        name="description[]">
                                                                                                    </x-input-textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="size" data-dz-size></p>
                                                                                            <div class="progress progress-striped active"
                                                                                                role="progressbar" aria-valuemin="0"
                                                                                                aria-valuemax="100" aria-valuenow="0">
                                                                                                <div class="progress-bar progress-bar-success"
                                                                                                    style="width:0%;"
                                                                                                    data-dz-uploadprogress>
                                                                                                </div>
                                                                                            </div>
                                                                                            <span class="badge bg-success">Uploaded
                                                                                                successfully</span>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-end ps-5">
                                                                                            <x-button :class="'btn-primary start'">
                                                                                                <span>Start</span>
                                                                                            </x-button>

                                                                                            <x-button data-dz-remove
                                                                                                :class="'btn-warning cancel'">
                                                                                                <span>Cancel</span>
                                                                                            </x-button>

                                                                                            <x-button data-dz-remove
                                                                                                :class="'btn-danger delete'">
                                                                                                <span>Delete</span>
                                                                                            </x-button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="dropzone-preview previews"
                                                                                    id="previews-presentation">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </x-form-post>
                                                        </div>
                                                        <div class="tab-pane fade" id="presentation-upload-storage" role="tabpanel">
                                                            <x-form-post action="{{ route('presentations.uploadByUrl') }}"
                                                                class="storeByUrlForm"
                                                                onsubmit="event.preventDefault()">
                                                                <div class="row">
                                                                    <x-input hidden type="url" name="fileUrl"
                                                                        id="fileUrlInput"
                                                                        class="alexusmaiFileUrlInput"></x-input>

                                                                    <div class="col-12 mt-3">
                                                                        <label class="form-text">Filename</label>
                                                                        <span
                                                                            class="alexusmaiFileText h5 text-secondary fw-bold"
                                                                            id="fileText">
                                                                        </span>
                                                                        <a href="javascript:void(0)"
                                                                            class="openStorageBtn btn btn-link"
                                                                            id="openStorageBtn">Open storage</a>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <x-label>Title</x-label>
                                                                        <x-input name="title"></x-input>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <x-label>Description</x-label>
                                                                        <x-input-textarea name="description">
                                                                        </x-input-textarea>
                                                                    </div>

                                                                    <div class="col-12 my-5">
                                                                        <button class="btn btn-success"
                                                                            type="submit">Submit</button>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="alert alert-danger fade">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </x-form-post>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- PREVIEW RESOURCE -->
                                        <div class="resource-submit-preview tab-pane fade" id="presentationSubmitPreview" role="tabpanel">
                                            <div class="resource-submit-preview-content border border-top-0 rounded p-3"
                                                id="presentationSubmitPreviewContent">
                                                <div class="alert alert-warning" role="alert">
                                                    There is no file being previewed yet.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RESOURCE DETAILS TAB -->
                        <div class="tab-pane fade" id="resource-modal-tabcontent-resource-details" role="tabpanel"
                            aria-labelledby="resource-modal-tabcontent-resource-details-tab">
                            <div class="pt-4">
                                <a href="javascript:void(0)" id="resource-details-tab-return">Return</a>

                                <div id="resource-details-tab-content" class="mt-5">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 mb-5">
                                            <header class="fs-5 fw-bold">Summary</header>

                                            <ul class="shadow list-group mt-3">
                                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                                    <div>
                                                        <h6 class="my-0"
                                                            id="resource-details-tab-resourcetype"></h6>
                                                        <small class="text-muted">Resource type</small>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between bg-primary text-white">
                                                    <span>Downloads</span>
                                                    <strong id="resource-details-tab-downloads"></strong>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between bg-light text-success">
                                                    <span> Views </span>
                                                    <strong id="resource-details-tab-views"></strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <header class="fs-5 fw-bold">Details</header>

                                            <div class="card border mt-3">
                                                <div class="card-body py-0">
                                                    <div class="row my-3 border-bottom">
                                                        <div class="col-12 fw-bold">Title</div>
                                                        <div class="col-12 ps-3" id="resource-details-tab-title">
                                                            qweqwe</div>
                                                    </div>

                                                    <div class="row mt-2 pb-1 border-bottom">
                                                        <div class="col-12 fw-bold">Description</div>
                                                        <div class="col-12 ps-3"
                                                            id="resource-details-tab-description"></div>
                                                    </div>

                                                    <div class="row mt-2 pb-1 border-bottom">
                                                        <div class="col-12 fw-bold">Uploader</div>
                                                        <div class="col-12 ps-3" id="resource-details-tab-uploader">
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2 pb-1 border-bottom">
                                                        <div class="col-12 fw-bold">File name</div>
                                                        <div class="col-12 ps-3" id="resource-details-tab-filename">
                                                            qwe</div>
                                                    </div>

                                                    <div class="row mt-2 pb-1 border-bottom">
                                                        <div class="col-12 fw-bold">File type</div>
                                                        <div class="col-12 ps-3" id="resource-details-tab-filetype">
                                                            qwe</div>
                                                    </div>

                                                    <div class="row mt-2 pb-1 border-bottom">
                                                        <div class="col-12 fw-bold">File size</div>
                                                        <div class="col-12 ps-3" id="resource-details-tab-filesize">
                                                            qwe</div>
                                                    </div>

                                                    <div class="row mt-2 pb-1 border-bottom">
                                                        <div class="col-12 fw-bold">Date uploaded</div>
                                                        <div class="col-12 ps-3" id="resource-details-tab-uploaded">
                                                            qwe</div>
                                                    </div>

                                                    <div class="row mt-2 pb-1 border-bottom">
                                                        <div class="col-12 fw-bold">Date updated</div>
                                                        <div class="col-12 ps-3" id="resource-details-tab-updated">
                                                            qwe</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div> --}}
            </div>
        </div>
    </div>


    <div class="modal" id="viewResourcesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Course Resources</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <small>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse perferendis dignissimos ullam
                        vitae hic doloribus!</small>
                    <form action="{{ route('resources.downloadAllByCourse') }}" method="post">
                        @csrf
                        <ul class="resource-list nav flex-column mt-3">

                        </ul>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary submit">Download all</button>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        {{-- {!! $dataTable->scripts() !!} --}}

        <script>
            $(document).ready(function() {
                function submittedResourceLogItemGenerator(resources, selector, parentSelector = null, startFromEnd = true) {
                    const $selector = parentSelector ? $(parentSelector).find(selector) : $(selector)

                    $selector.html('')
                    if($(resources).length <= 0) {
                        $selector.addClass('text-center')
                        $selector.html(`
                            <li class="list-group-item">
                                <img title="alert triangle" alt="alert triangle icon" class="img-thumbnail" src="{{asset('images/icons/alert-triangle.svg')}}" />
                                <h5 class="form-text fw-bold">There are no recent submissions yet.</h5>
                            </li>
                        `)
                    }

                    $(resources).each(function(index, item) {
                        let fileSubmissionDate = moment(item.created_at).format('MM-DD-YYYY : LT')
                        let fileName = item.media[0] ? item.media[0].file_name :'unknown file'

                        const markUp = `
                                <li class="logsRootList list-group-item hstack gap-3">
                                    <div class="flex-1 overflow-hidden">
                                        <span class="text-truncate d-block" title="${fileName}"> ${fileName} </span>
                                        <small class="text-muted">File name</small>
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <span class="text-nowrap d-block" title="${fileSubmissionDate}"> ${fileSubmissionDate} </span>
                                        <small class="text-muted">Date</small>
                                    </div>
                                    <span class="vr"></span>
                                    <div>
                                        <div class="btn-group dropend">
                                            <button class="btn" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                            </button>
                                            <ul class="dropdown-menu shadow border-0 p-0">
                                                <li class="dropdown-item p-0">
                                                    <ul class="list-group" style="min-width: 300px">
                                                        <li class="list-group-item">
                                                            <div>
                                                                <h6 class="my-0 fw-bold">
                                                                    ${item.user.username}
                                                                </h6>
                                                                <small class="text-muted">Submitter</small>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div>
                                                                <h6 class="my-0 fw-bold">
                                                                    ${item.approved_at ? 'approved' : item.rejected_at ? 'rejected' : 'for approval'}
                                                                </h6>
                                                                <small class="text-muted">Status</small>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button data-preview-id="${item.id}" data-preview-filetype="${item.filetype}" class="preview-resource submitGeneralPreviewBtns w-100 btn btn-light border text-primary fw-bold">
                                                                        Preview
                                                                    </button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <button data-unsubmit-id="${item.id}" class="unsubmit-resource generalLogsUnsubmit ${item.approved_at ? 'd-none' : ''} w-100 btn btn-light border-danger text-danger fw-bold">
                                                                        Unsubmit
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            `
                        if(startFromEnd) {
                            $selector.append(markUp)
                        } else {
                            $selector.prepend(markUp)
                        }
                    })
                }

                /* CUSTOM EVENTS */
                $(document).on('resourceSubmitStart', function(event) {
                    // disable submit btn/form
                    // add loading spinner
                })

                $(document).on('resourceSubmittedSuccessful', function(event) {
                    // fetch current list of resources
                    // update log list
                    // add log item
                    // increase log count
                    // show success popup
                })

                $(document).on('resourceSubmittedFail', function(event) {
                    // show error alert
                    // main error message
                    // list of errors
                })

                $(document).on('resourceSubmitEnd', function(event) {
                    // enable submit btn/form
                    // remove loading spinner
                })

                let fmWindow;
                $('.openStorageBtn').click(function(event) {
                    fmWindow = window.open('/file-manager/summernote?leftPath=users/{{ auth()->id() }}',
                        'fm',
                        'width=1400,height=800');

                    fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
                        window.opener.fmSetLink(fileUrl);
                        fmWindow.close();
                    });
                });

                /* ON RESOURCE MODAL SHOW */
                $('#exampleModal').on('show.bs.modal', function(event) {
                    const firstViewTab = bootstrap.Tab.getOrCreateInstance($('#resource-modal-tabcontent-general-tab')[0])
                    firstViewTab.show()
                })

                /* ON RESOURCE MODAL SHOWN */
                $('#exampleModal').on('shown.bs.modal', function(event) {
                    const $currentModal = $('#exampleModal')
                    let targetCourseId = $(event.relatedTarget).attr('data-bs-courseid')
                    let targetCourseTitle = $(event.relatedTarget).attr('data-bs-coursetitle')

                    // populate modal data
                    $('[name="course_id"]').val(targetCourseId)
                    $('#resource-modal-label').text(targetCourseTitle)

                    /* Course Modal Refresh Event
                    1. populate course resource datatable
                    2. populate course cards data
                    3. populate resource submit tab data
                    */
                    $currentModal.off('courseModal:refresh')
                    $currentModal.on( "courseModal:refresh", function( event ) {
                        // destroy current instance of datatable if already instantiated
                        if ($.fn.DataTable.isDataTable('#resources-table')) {
                            $('#resources-table').DataTable().clear();
                            $('#resources-table').DataTable().destroy();
                        }

                        // instantiate & populate datatable
                        if (!$.fn.DataTable.isDataTable('#resources-table')) {
                            window.LaravelDataTables = window.LaravelDataTables || {};
                            window.LaravelDataTables["resources-table"] = $("#resources-table").DataTable({
                                "serverSide": true,
                                "processing": true,
                                "ajax": {
                                    "data": function(d) {
                                        d.course_id = targetCourseId;
                                    }
                                },
                                "columns": [{
                                    "data": "action",
                                    "name": "action",
                                    "title": "Action",
                                    "orderable": false,
                                    "searchable": false,
                                    "width": 60
                                }, {
                                    "data": "media",
                                    "name": "media",
                                    "title": "Media",
                                    "orderable": true,
                                    "searchable": true
                                }, {
                                    "data": "description",
                                    "name": "description",
                                    "title": "Description",
                                    "orderable": true,
                                    "searchable": true
                                }, {
                                    "data": "date_uploaded",
                                    "name": "date_uploaded",
                                    "title": "Date Uploaded",
                                    "orderable": true,
                                    "searchable": true,
                                    "sortable": false
                                }],
                                "dom": "Bfrtip",
                                "order": [
                                    [1, "desc"]
                                ]
                            });
                        }

                        // start ajax
                        let courseUrl = `{{ route('courses.index') }}/${targetCourseId}`
                        $.ajax({
                                method: "GET",
                                url: courseUrl,
                                beforeSend: function() {
                                    spinnerGenerator(`.course-resource-card, .submit-resource-log`)
                                }
                        })
                        .done(function(data) {

                            // syllabus card
                            if(data.syllabus) {
                                $('#course-syllabus-card').html(`
                                <div>
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="list-group">
                                                <li class="list-group-item hstack justify-content-between">
                                                        <div>
                                                            <h6 class="my-0 fw-bold">${data.syllabus.title}</h6>
                                                            <small class="text-muted">Title</small>
                                                        </div>
                                                </li>
                                                <li class="list-group-item">
                                                        <h6 class="my-0 fw-bold">${data.syllabus.user.username}</h6>
                                                        <small class="text-muted">Submitter</small>
                                                </li>
                                                <li class="list-group-item">
                                                        <h6 class="my-0 fw-bold">${data.syllabus.created_at}</h6>
                                                        <small class="text-muted">Submitted on</small>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                        <div class="btn-group" role="group" aria-label="First group">
                                                            <a href="{{route('resources.index')}}/download/${data.syllabus.id}" class="p-1 btn btn-outline-secondary">
                                                                <img title="download" alt="download icon" class="img-thumbnail" src="{{asset('images/icons/download.svg')}}" />
                                                            </a>
                                                            <button type="button" class="p-1 btn btn-outline-secondary">
                                                                <img title="archives" alt="archive icon" class="img-thumbnail" src="{{asset('images/icons/archive.svg')}}" />
                                                            </button>
                                                        </div>
                                                    </div>
                                                        <small class="text-muted">Actions</small>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            `)
                            } else {
                                $('#course-syllabus-card').addClass('text-center')
                                $('#course-syllabus-card').html(`
                                    <img title="alert triangle" alt="alert triangle icon" class="img-thumbnail" src="{{asset('images/icons/alert-triangle.svg')}}" />
                                    <h5 class="form-text fw-bold">This course has no syllabus yet.</h5>
                                `)
                            }

                            // recent submissions card
                            if (data.courseResourceLogs.length > 0) {
                                $('#recent-resource-uploads-card').html(`<ul class="list-group"></ul>`)
                                $(data.courseResourceLogs).each(function(index, item) {
                                    let fileSubmissionDate = moment(item.created_at).format('MM-DD-YYYY : LT')
                                    let resourceType = item.isSyllabus ? 'Syllabus' : item.isPresentation ? 'Presentation' : 'General'
                                    let submitter = item.user ? item.user.username : 'unknown user'
                                    $('#recent-resource-uploads-card .list-group').append(`
                                        <li class="list-group-item hstack gap-3">
                                            <div class="flex-1 overflow-hidden">
                                                <span class="text-truncate d-block" title="${resourceType}"> ${resourceType} </span>
                                                <small class="text-muted">Resource type</small>
                                            </div>
                                            <div class="flex-1 overflow-hidden">
                                                <span class="text-nowrap" title="${submitter}"> ${submitter} </span>
                                                <small class="text-muted">Submitter</small>
                                            </div>
                                            <div class="flex-1 overflow-hidden">
                                                <span class="text-nowrap d-block" title="${fileSubmissionDate}"> ${fileSubmissionDate} </span>
                                                <small class="text-muted">Date</small>
                                            </div>
                                        </li>
                                    `)
                                })
                            } else {
                                $('#recent-resource-uploads-card').addClass('text-center')
                                $('#recent-resource-uploads-card').html(`
                                    <img title="alert triangle" alt="alert triangle icon" class="img-thumbnail" src="{{asset('images/icons/alert-triangle.svg')}}" />
                                    <h5 class="form-text fw-bold">This course have no submissions yet.</h5>
                                `)
                            }

                            // total submissions card
                            $('#resource-uploads-card').html(`
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h4 class="my-0 fw-bold">${data.totalSubmits}</h4>
                                        <small class="text-muted">Total</small>
                                    </li>
                                    <li class="list-group-item hstack justify-content-between">
                                        <div>
                                            <h6 class="my-0 d-block">${data.resourceLogCount}</h6>
                                            <small class="text-muted">General</small>
                                        </div>
                                        <div>
                                            <h4>${data.resourceLogCount ? ((data.resourceLogCount / data.totalSubmits) * 100).toFixed(2) : 0} %</h4>
                                        </div>
                                    </li>
                                    <li class="list-group-item hstack justify-content-between">
                                        <div>
                                            <h6 class="my-0 d-block">${data.syllabiLogCount}</h6>
                                            <small class="text-muted">Syllabus</small>
                                        </div>
                                        <div>
                                            <h4>${data.syllabiLogCount ? ((data.syllabiLogCount / data.totalSubmits) * 100).toFixed(2) : 0} %</h4>
                                        </div>
                                    </li>
                                    <li class="list-group-item hstack justify-content-between">
                                        <div>
                                            <h6 class="my-0 d-block">${data.presentationLogCount}</h6>
                                            <small class="text-muted">Presentations</small>
                                        </div>
                                        <div>
                                            <h4>${data.presentationLogCount ? ((data.presentationLogCount / data.totalSubmits) * 100).toFixed(2) : 0} %</h4>
                                        </div>
                                    </li>
                                </ul>
                            `)

                            // syllabus status
                            $('#submit-syllabus-tab-status')
                                .text(`${data.complied ? 'Fulfilled' : 'Unfulfilled'}`)
                                .addClass(`${data.complied ? 'text-primary' : 'text-danger'}`)

                            // resource submit logs
                            submittedResourceLogItemGenerator(data.resourceLogs,'#submit-general-log')
                            submittedResourceLogItemGenerator(data.logs,'#submit-syllabus-log')
                            data.complied
                            ?   $('#submit-syllabus-tab-status').addClass('text-primary').removeClass('text-danger').text('Fulfilled')
                            :   $('#submit-syllabus-tab-status').addClass('text-danger').removeClass('text-primary').text('Unfulfilled')
                            submittedResourceLogItemGenerator(data.presentationLogs,'#submit-presentation-log')
                        })
                        .fail(function(error) {
                            const errorResponse = error.responseJSON

                            errorAlertGenerator('.modal-body', errorResponse.message, $currentModal)
                        })
                        .always(function() {
                            //remove spinners
                            spinnerGenerator(`.course-resource-card, .submit-resource-log`, null, true)
                        })

                    })
                    $currentModal.trigger('courseModal:refresh')

                    /* ON SHOW SUBMIT TABS */
                    $('.submit-resource-tab').on('shown.bs.tab', function(event) {
                        const $targetTabpaneId = $(event.target).attr('data-bs-target')
                        const $targetTabpaneLabel = $(event.target).attr('data-label')

                        const $dropzone = $($targetTabpaneId)

                        if ($dropzone[0].dropzone) return

                        let $previewNode = $dropzone.find(".dropzone-template");
                        let previewTemplate = $previewNode.parent().html();
                        $previewNode.parent().remove('.dropzone-template')

                        let dropzoneParams = {
                            url: "{{ route('upload-temporary-file.store') }}", // Set the url
                            params: {
                                _token: "{{ csrf_token() }}"
                            },
                            thumbnailWidth: 120,
                            thumbnailHeight: 120,
                            parallelUploads: 20,
                            previewTemplate: previewTemplate,
                            autoQueue: true, // Make sure the files aren't queued until manually added
                            previewsContainer: `${$targetTabpaneId} .dropzone-preview`, // Define the container to display the previews
                            clickable: `${$targetTabpaneId} .fileinput-button`, // Define the element that should be used as click trigger to select files.
                            maxFilesize: 5000
                        }

                        if ($targetTabpaneLabel === 'general') {
                            dropzoneParams['maxFiles'] = 5,
                            dropzoneParams['accept'] = function(file, done) {
                                if (
                                    file.type
                                ) {
                                    done();
                                } else {
                                    done("Error! Valid files should have a file extension.");
                                }
                            }
                        } else if ($targetTabpaneLabel === 'syllabus') {
                            dropzoneParams['maxFiles'] = 1
                            dropzoneParams['accept'] = function(file, done) {
                                if (
                                    file.type ==
                                    "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                    || file.type == "application/msword"
                                ) {
                                    done();
                                } else {
                                    done("Error! You have to submit a docx or doc file.");
                                }
                            }
                        } else if ($targetTabpaneLabel === 'presentation') {
                            dropzoneParams['maxFiles'] = 1
                            dropzoneParams['accept'] = function(file, done) {
                                if (
                                    file.type ==
                                    "application/vnd.ms-powerpoint"
                                    || file.type ==
                                    "application/vnd.openxmlformats-officedocument.presentationml.presentation"
                                ) {
                                    done();
                                } else {
                                    done("Error! You have to submit a pptx or ppt file.");
                                }
                            }
                        }

                        // Make the target tabpane a dropzone
                        let DropzoneInstance = new Dropzone($dropzone[0], dropzoneParams);

                        DropzoneInstance.on("addedfile", function(file) {
                            $dropzone.find('.submit-resource-alert').parent('.alert').removeClass('show')
                        });

                        DropzoneInstance.on("removedfile", function(file) {
                            let $input = $dropzone.find(
                                    '.dropzone-preview .dz-success .file-metadata input[name="title[]"]'),
                                $submitButton = $dropzone.find(
                                    '.submit-resource-form button[type="submit"]');

                            $input.unbind('keyup');
                            let trigger = false;

                            if ($input.length <= 0) {
                                console.log($input.length)
                                trigger = true;
                            } else {
                                $input.each(function() {
                                    if (!$(this).val()) {
                                        trigger = true;
                                    }
                                });
                            }

                            trigger ? $submitButton.addClass('disabled') : $submitButton
                                .removeClass(
                                    'disabled');

                            $dropzone.find('.dropzone-preview .file-metadata').delegate($input, 'keyup',
                                function(e) {
                                    let trigger = false;

                                    $input.each(function() {
                                        if (!$(this).val()) {
                                            trigger = true;
                                        }
                                    });

                                    trigger ? $submitButton.addClass('disabled') : $submitButton
                                        .removeClass(
                                            'disabled');
                                })

                            if (DropzoneInstance.files.length <= 0) {
                                $dropzone.find(".submit-resource-form-actions .cancel").addClass('d-none')
                                $submitButton.addClass('d-none')
                            }
                        })

                        // Update the total progress bar
                        DropzoneInstance.on("totaluploadprogress", function(progress) {
                            $dropzone.find('.progress .progress-bar').css('width', progress + '%');
                        });

                        DropzoneInstance.on("sending", function(file) {
                            // Show the total progress bar when upload starts
                            $dropzone.find('.progress').css('opacity', 1);
                            $dropzone.find('.progress .progress-bar').css('width', '0%');

                            // And disable the start button
                            $(file.previewElement).find('.start').attr('disabled', 'disabled')
                        });

                        DropzoneInstance.on("success", function(file) {
                            $(file.previewElement).find('.file').val(file.xhr.responseText)
                            $(file.previewElement).find('.file-group').removeClass('d-none')

                            let $input = $dropzone.find(
                                    '.dropzone-preview .file-metadata input[name="title[]"]'),
                                $submitButton = $dropzone.find(
                                    '.submit-resource-form button[type="submit"]');

                            $submitButton.addClass('disabled')

                            $dropzone.find('.dropzone-preview .file-metadata').delegate($input, 'keyup',
                                function(e) {
                                    let trigger = false;

                                    $input.each(function() {
                                        console.log($(this).val())
                                        if (!$(this).val()) {
                                            trigger = true;
                                        }
                                    });

                                    trigger ? $submitButton.addClass('disabled') : $submitButton
                                        .removeClass(
                                            'disabled');
                                })

                            $dropzone.find(".submit-resource-form-actions .cancel").removeClass('d-none')
                            $submitButton.removeClass('d-none')
                        });

                        // Hide the total progress bar when nothing's uploading anymore
                        DropzoneInstance.on("queuecomplete", function(progress) {
                            $dropzone.find('.progress').css('opacity', 0);
                        });

                        /* ON REMOVE ALL FILES */
                        $(".submit-resource-form-actions .cancel").click(function() {
                            DropzoneInstance.removeAllFiles(true);
                        });

                        /* ON DRAG FILE */
                        $dropzone.find('.fileinput-button').children().addClass('pe-none')
                        $dropzone.find('.fileinput-button').on(
                            'dragover',
                            function(event) {
                                $(event.target)
                                    .addClass('shadow-lg fw-bold')
                                    .css('height', '150px')
                            }
                        )
                        $dropzone.find('.fileinput-button').on(
                            'dragleave',
                            function(event) {
                                beforeDragDropzoneStyle(event.target)
                            }
                        )
                        $dropzone.find('.fileinput-button').on(
                            'drop',
                            function(event) {
                                beforeDragDropzoneStyle(event.target)
                                $('#syllabus-iframe-container').html('')
                            }
                        )

                        function beforeDragDropzoneStyle(dropzone) {
                            $(dropzone)
                                .removeClass('shadow-lg fw-bold')
                                .css('height', '100px')
                        }

                        /* ON SUBMIT RESOURCE */
                        $dropzone.find('.submit-resource-form button[type="submit"]').click(function(event) {
                            let files = [],
                                titles = [],
                                descriptions = []
                            $dropzone.find('.dropzone-preview [name="file[]"]').each(function(index,
                                item) {
                                files.push($(item).val())
                            })
                            $dropzone.find('.dropzone-preview [name="title[]"]').each(function(index,
                                item) {
                                titles.push($(item).val())
                            })
                            $dropzone.find('.dropzone-preview [name="description[]"]').each(function(
                                index, item) {
                                descriptions.push($(item).val())
                            })

                            let formRoute = $dropzone.find('.submit-resource-form').attr('action')
                            $.ajax({
                                    method: "POST",
                                    url: formRoute,
                                    data: {
                                        'file': files,
                                        'course_id': $dropzone.find('.submit-resource-form [name="course_id"]').val(),
                                        'title': titles,
                                        'description': descriptions,
                                    },
                                    beforeSend: function() {
                                        $('#syllabus-iframe-container').html('')
                                        $('#presentation-iframe-container').html('')
                                    }
                                })
                                .done(function(data) {
                                    DropzoneInstance.removeAllFiles(true);
                                    $dropzone.find('.submit-resource-form-actions .cancel').addClass(
                                        'd-none')
                                    $(event.target).addClass('d-none')

                                    if($targetTabpaneLabel == 'general') {
                                        $dropzone.find('#resources-table').DataTable().draw('page')
                                        $dropzone.find('.submit-resource-alert').parent().addClass('show')
                                        $dropzone.find('.submit-resource-alert').text(data.message)

                                        $currentModal.trigger('courseModal:refresh')
                                    } else if ($targetTabpaneLabel == 'syllabus') {
                                        /* !Reminder: MIGRATE PHP JS SCRIPT TO JS ONLY*/
                                        $('#syllabus-iframe-container').append(data.embed)
                                    } else if($targetTabpaneLabel == 'presentation') {
                                        $('#presentation-iframe-container').append(
                                        '<ul id="presentation-slide-list"></ul>')

                                        if (data.status == 'ok') {
                                            $('#submit-resource-alert-presentation').parent().addClass(
                                                'show')
                                            $('#submit-resource-alert-presentation').text(data.message)
                                            $('#resources-table').DataTable().draw('page')

                                            $currentModal.trigger('courseModal:refresh')
                                        } else {
                                            $(data.texts).each(function(index, item) {
                                                $('#presentation-slide-list').append(
                                                    `<li>${item}</li>`
                                                )
                                            })
                                            $('#presentation-iframe-container').prepend(
                                                ` <div class="h5 fw-bold">
                                                These are the texts that were found on the last page of your uploaded presentation.
                                            </div>`
                                            )
                                            $('#presentation-iframe-container').prepend(
                                                `<div class="alert alert-danger h4">
                                                The last slide/page of your presentation must contain a section labeled as <strong>reference/references.</strong>
                                            </div>`
                                            )
                                        }

                                        // $('#presentation-iframe-container').append(data.embed)
                                    }

                                })
                                .fail(function(error) {
                                    if(error.responseJSON.code == '500') {
                                        errorAlertGenerator('.submit-resource-form', error.responseJSON.message, $dropzone)
                                    }
                                })
                                .always(function() {
                                    spinnerGenerator($(event.target), null, true, 'text-white')
                                    $(event.target).text('Submit')
                                });
                        })

                        // /* SUBMIT RESOURCE LINK AJAX */
                        $dropzone.find('.storeByUrlForm [type="submit"]').click(function(event) {
                            $dropzone.find('.storeByUrlForm .alert-danger').hide()

                            const $formFields = $dropzone.find('.storeByUrlForm').serializeArray()
                            const jsonData = {}
                            $.each($formFields, function(index, field) {
                                jsonData[field.name] = field.value
                            })
                            jsonData['course_id'] = $('[name="course_id"]').first().val()

                            $.ajax({
                                    method: "POST",
                                    url: $dropzone.find('.storeByUrlForm').attr('action'),
                                    data: jsonData,
                                    beforeSend: function() {
                                        spinnerGenerator(event.target, null, false, 'text-white')
                                        $dropzone.find('#url-form-syllabus-validation').remove()
                                        $dropzone.find('#presentation-upload-storage #presentation-iframe-container').remove()
                                    }
                                })
                                .done(function(data) {
                                    $currentModal.trigger('courseModal:refresh');
                                    $dropzone.find('.storeByUrlForm')[0].reset()
                                    $dropzone.find('.alexusmaiFileText').text('')

                                    // syllabus
                                    if(data.embed) {
                                        $dropzone.find('.storeByUrlForm').append(`<div id="syllabus-iframe-container" class="w-100">${data.embed}</div>`)
                                    }

                                    // presentation
                                    if(data.texts) {
                                        $dropzone.find('.storeByUrlForm')
                                            .append(`<div id="presentation-iframe-container" class="w-100">
                                                <ul id="presentation-slide-list"></ul>
                                            </div>`)
                                        $(data.texts).each(function(index, item) {
                                            $dropzone.find('#presentation-upload-storage #presentation-slide-list').append(
                                                `<li>${item}</li>`
                                            )
                                        })

                                        $dropzone.find('#presentation-upload-storage #presentation-iframe-container').prepend(
                                            ` <div class="h5 fw-bold">
                                            These are the texts that were found on the last page of your uploaded presentation.
                                        </div>`
                                        )
                                        $dropzone.find('#presentation-upload-storage #presentation-iframe-container').prepend(
                                            `<div class="alert alert-danger h4">
                                            The last slide/page of your presentation must contain a section labeled as <strong>reference/references.</strong>
                                        </div>`
                                        )
                                    }
                                })
                                .fail(function(response) {
                                    response = response.responseJSON
                                    $dropzone.find('.storeByUrlForm .alert-danger').stop(true, true)
                                    $dropzone.find('.storeByUrlForm .alert-danger').fadeTo(2000, 500);
                                    $dropzone.find('.storeByUrlForm .alert-danger').html(
                                        `<h5>You got few validation errors.</h5>
                                        <ul class="formErrorList"></ul>
                                        `
                                    )
                                    $.each(response.errors, function(key, error) {
                                        $dropzone.find('.storeByUrlForm .formErrorList').append(
                                            `<li>${error}</li>`
                                        )
                                    })
                                })
                                .always(function() {
                                    spinnerGenerator(event.target, null, true)
                                    $(event.target).text('Submit');
                                });
                        })

                        $dropzone.find('.submit-resource-log').delegate('.unsubmit-resource', 'click',
                            function(event) {
                                let deleteUrl = '{{ route('resources.index') }}'
                                deleteUrl =
                                    `${deleteUrl}/${$(event.target).attr('data-unsubmit-id')}`

                                $.ajax({
                                        method: "POST",
                                        url: deleteUrl,
                                        data: {
                                            '_method': 'DELETE'
                                        },
                                        beforeSend: function() {
                                            spinnerGenerator(event.target)
                                        }
                                    })
                                    .done(function(data) {
                                        if (data.status == 'ok') {
                                            // $(event.target).closest('.logsRootList').remove()
                                            $currentModal.trigger( "courseModal:refresh")
                                        }
                                    })
                                    .fail(function() {
                                        // alert("error");
                                    })
                                    .always(function() {
                                        spinnerGenerator(event.target, null, true)
                                        $(event.target).text('Unsubmit')
                                    });
                        })

                        const generalSubmitPreviewTab = $dropzone.find('.resource-submit-preview-tab')[0]

                        let onPreview = false;
                        $dropzone.find('.submit-resource-log').delegate('.preview-resource', 'click',
                            function(event) {
                                if (onPreview) return;

                                onPreview = true;

                                $dropzone.find('.submit-resource-log .logsRootList').removeClass(
                                    'shadow-lg border-5 border-primary fw-bold  ')
                                $(event.target).closest('.logsRootList').addClass(
                                    'shadow-lg border-5 border-primary fw-bold')

                                $(event.target).html(`<div class="d-flex justify-content-center align-items-center">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>`)

                                bootstrap.Tab.getOrCreateInstance(
                                    generalSubmitPreviewTab).show()

                                let previewUrl = '{{ route('resources.index') }}'
                                previewUrl =
                                    `${previewUrl}/preview/${$(event.target).attr('data-preview-id')}`

                                $dropzone.find('.resource-submit-preview-content')
                                    .html(`<div class="d-flex justify-content-center align-items-center">
                                    <div class="spinner-border text-primary" role="status"></div>
                                    </div>`)

                                const filetypes = @json(config('app.pdf_convertible_filetypes'));
                                if ($.inArray($(event.target).attr('data-preview-filetype'),
                                        filetypes) == -1) {
                                    /* IF NOT PDF CONVERTIBLE */
                                    $.ajax({
                                            method: "GET",
                                            url: previewUrl,
                                            // beforeSend: function(){
                                            //     onPreview = true
                                            // },
                                        })
                                        .done(function(data) {
                                            const downloadRoute =
                                                '{{ route('resources.index') }}'
                                            $dropzone.find('.resource-submit-preview-content').html(
                                                `<div class="mb-4">
                                            <a class="btn btn-primary" href="${downloadRoute}/download/${$(event.target).attr('data-preview-id')}">Download</a>
                                            <a class="btn btn-secondary ms-2" id="generalSubmitPreviewFullscreen" href="javascript:void(0)">Fullscreen</a>
                                        </div>`
                                            )

                                            if (data.fileType === 'text_filetypes') {
                                                $dropzone.find('.resource-submit-preview-content').append(
                                                    '<textarea class="preview-resource-summernote" id="previewGeneralSummernote"></textarea>'
                                                )
                                                $dropzone.find('.preview-resource-summernote').summernote({
                                                    'toolbar': [],
                                                    codeviewFilter: false,
                                                    codeviewIframeFilter: true
                                                })
                                                $dropzone.find('.preview-resource-summernote').summernote(
                                                    'code',
                                                    data.resourceText)
                                                $dropzone.find('.preview-resource-summernote').summernote(
                                                    'disable')
                                            }

                                            if (data.fileType === 'img_filetypes') {
                                                $dropzone.find('.resource-submit-preview-content').append(
                                                    `<img style="width: 100%" src="${data.resourceUrl}" />`
                                                )
                                            }

                                            if (data.fileType === 'video_filetypes') {
                                                console.log(data)
                                                $dropzone.find('.resource-submit-preview-content').append(
                                                    `<video width="320" height="240" controls autoplay>
                                                <source src="${data.resourceUrl}" type="video/mp4">
                                            </video>`
                                                )
                                            }

                                            if (data.fileType === 'audio_filetypes') {
                                                $dropzone.find('.resource-submit-preview-content').append(
                                                    `<audio controls autoplay>
                                                <source src="${data.resourceUrl}" type="audio/mpeg">
                                            </audio>`
                                                )
                                            }
                                        })
                                        .fail(function(error) {
                                            $dropzone.find('.resource-submit-preview-content').html(
                                                `<div class="alert alert-danger" role="alert">
                                            ${error.responseJSON.message}
                                        </div>`
                                            )
                                        })
                                        .always(function() {
                                            $(event.target).text(`Preview`)
                                            onPreview = false;
                                        });
                                } else {
                                    /* IF PDF CONVERTIBLE */
                                    var thePdf = null;
                                    var scale = 1;
                                    pdfjsLib.getDocument(previewUrl).promise.then(pdf => {
                                        onPreview = false;

                                        const downloadRoute =
                                            '{{ route('resources.index') }}'
                                        $dropzone.find('.resource-submit-preview-content').html(
                                            `
                                            <div class="mb-4">
                                                <a class="btn btn-primary" href="${downloadRoute}/download/${$(event.target).attr('data-preview-id')}">Download</a>
                                                <a class="btn btn-secondary ms-2" id="generalSubmitPreviewFullscreen" href="javascript:void(0)">Fullscreen</a>
                                            </div>
                                            `
                                        )

                                        thePdf = pdf;
                                        viewer = $dropzone.find('.resource-submit-preview-content')[0];

                                        for (page = 1; page <= pdf
                                            .numPages; page++) {
                                            canvas = document.createElement(
                                                "canvas");
                                            canvas.className = 'd-block w-100 mx-auto';
                                            canvas.style.maxWidth = '900px';
                                            viewer.appendChild(canvas);
                                            renderPage(page, canvas);
                                        }

                                        $(event.target).html(`Preview`)
                                    }).catch((error) => {
                                        onPreview = false;

                                        $(event.target).html(`Preview`)

                                        $dropzone.find('.resource-submit-preview-content').html(
                                            `<div class="alert alert-danger" role="alert">
                                            File was not able to be previewed due to certain error. Try again!
                                        </div>`
                                        )
                                    })

                                    function renderPage(pageNumber, canvas) {
                                        thePdf.getPage(pageNumber).then(function(page) {
                                            viewport = page.getViewport({
                                                scale: scale
                                            });
                                            canvas.height = viewport.height;
                                            canvas.width = viewport.width;
                                            page.render({
                                                canvasContext: canvas
                                                    .getContext('2d'),
                                                viewport: viewport
                                            });
                                        });
                                    }
                                }

                                let isFullscreen = false
                                $dropzone.find('.resource-submit-preview').delegate(
                                    '#generalSubmitPreviewFullscreen', 'click',
                                    (event) => {
                                        if (!isFullscreen) {
                                            openFullscreen($dropzone.find(
                                                '.resource-submit-preview-content'
                                            )[0])

                                            $(event.target).text(
                                                'Cancel fullscreen')
                                            isFullscreen = true
                                        } else {
                                            closeFullscreen($dropzone.find(
                                                '.resource-submit-preview-content'
                                            )[0])

                                            $(event.target).text('Fullscreen')
                                            isFullscreen = false
                                        }
                                    })

                                function openFullscreen(elem) {
                                    $(elem)
                                        .css('position', 'absolute')
                                        .css('width', '100%')
                                        .css('height', '100%')
                                        .css('left', '0')
                                        .css('top', '0')
                                        .css('background-color', '#fff')
                                }

                                function closeFullscreen(elem) {
                                    $(elem)
                                        .css('position', '')
                                        .css('width', '')
                                        .css('height', '100%')
                                        .css('left', '')
                                        .css('top', '')
                                        .css('background-color', '')
                                }
                        })
                    })
                })

                /* ON SHOW DETAILS TAB */
                $('#resources-table').on('draw.dt', function() {
                    const triggerEl = document.querySelector(
                        '#resource-modal-tabcontent-resource-details-tab')

                    $('.resource-modal-tabcontent-resource-details-tab').click(function(event) {
                        bootstrap.Tab.getOrCreateInstance(triggerEl).show()
                        let resourceId = $(event.target).attr('data-id')
                        let resourceUrl = '{{ route('resources.index') }}'
                        resourceUrl = `${resourceUrl}/${resourceId}`
                        $.ajax({
                                method: "GET",
                                url: resourceUrl,
                            })
                            .done(function(data) {
                                console.log(data)
                                // SUMMARY SECTION
                                $('#resource-details-tab-resourcetype').text(data
                                    .is_syllabus ?
                                    'Syllabus' : 'General')
                                $('#resource-details-tab-downloads').text(data
                                    .downloads ?? 0)
                                $('#resource-details-tab-views').text(data.views ?? 0)

                                // DETAILS SECTION
                                $('#resource-details-tab-title').text(data.title)
                                $('#resource-details-tab-description').text(data
                                    .description)
                                $('#resource-details-tab-uploader').text(data.uploader)
                                $('#resource-details-tab-filename').text(data.filename)
                                $('#resource-details-tab-filetype').text(data.filetype)
                                $('#resource-details-tab-filesize').text(data.filesize)
                                $('#resource-details-tab-uploaded').text(data
                                    .created_at)
                                $('#resource-details-tab-updated').text(data.updated_at)

                            })
                            .fail(function() {
                                alert("error");
                            })
                            .always(function() {
                                // $(event.target).removeClass('loading disabled')
                            });
                    })

                    $('#resource-modal-tabcontent-submit-syllabus-tab').click(function(event) {

                    })
                })

                /* ON NAVPILL TAB SHOW */
                $('#pills-tab [data-bs-toggle="pill"]').on('shown.bs.tab', function(event) {
                    $('#resource-modal-body').scrollTop(0)
                })

                /* DROPDOWN EVENT */
                $('#submit-resource-dropdown').on('shown.bs.dropdown', function(event) {
                    const dd = this
                    const ddlink = event.target
                    $(dd).find('.dropdown-item').click(function(event) {
                        $(ddlink).text(`Submit ${$(event.target).text()}`)
                    })
                })

            });

            function fmSetLink(url) {
                console.log(url)
                let filename = url.split('/').pop();

                $('.submit-resource-tabpane.tab-pane.active .alexusmaiFileUrlInput').val(url)
                $('.submit-resource-tabpane.tab-pane.active .alexusmaiFileText').text(filename)
            }
        </script>
    @endsection
</x-app-layout>
