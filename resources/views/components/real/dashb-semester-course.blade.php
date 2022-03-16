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
    <div class="col-12">
        <x-real.row-header>
            <x-slot name="title">{{ $semesters->firstWhere('key', $semester)['label'] }}</x-slot>
        </x-real.row-header>
    </div>

    <div class="row g-3 gy-lg-0">
        <!-- FIRST TERM -->
        <div class="col-lg-6">
            <x-real.card>
                <x-slot name="header">
                    First Term
                </x-slot>

                <x-slot name="body">
                    <x-real.table>
                        <x-slot name="headers">
                            <th scope="col">Action</th>
                            <th scope="col">Subject code</th>
                            <th scope="col">Subject title</th>
                        </x-slot>

                        <x-slot name="rows">
                            @forelse ($courses->where('semester', $semester)->where('term', 1) as $row)
                                <tr>
                                    <td>
                                        <a href="{{ route('instructor.course.show', $row->id) }}"
                                            class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                        {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-bs-courseid="{{ $row->id }}"
                                    data-bs-coursetitle="{{ $row->title }} [{{ $row->code }}]">Resources</button> --}}
                                    </td>
                                    <td>{{ $row->code }}</td>
                                    <td>{{ $row->title }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3">
                                        <x-real.no-rows :variant="'light'">
                                            <x-slot name="label">No course available in table</x-slot>
                                        </x-real.no-rows>
                                    </td>
                                </tr>
                            @endforelse
                        </x-slot>
                    </x-real.table>
                </x-slot>
            </x-real.card>
        </div>

        <!-- SECOND TERM -->
        <div class="col-lg-6">
            <x-real.card>
                <x-slot name="header">
                    Second Term
                </x-slot>

                <x-slot name="body">
                    <x-real.table>
                        <x-slot name="headers">
                            <th scope="col">Action</th>
                            <th scope="col">Subject code</th>
                            <th scope="col">Subject title</th>
                        </x-slot>

                        <x-slot name="rows">
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
                                        <x-real.no-rows :variant="'light'">
                                            <x-slot name="label">No course available in table</x-slot>
                                        </x-real.no-rows>
                                    </td>
                                </tr>
                            @endforelse
                        </x-slot>
                    </x-real.table>
                </x-slot>
            </x-real.card>
        </div>
    </div>
</section>
