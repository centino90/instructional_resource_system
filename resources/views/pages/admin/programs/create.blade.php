<x-app-layout>
    <x-slot name="header">
        Edit Program
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('admin.programs.index') }}">
                <- Go back </a>
        </li>
        <li class="breadcrumb-item ">
            <a href="{{ route('dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item ">
            <a href="{{ route('admin.programs.index') }}">Program Management</a>
        </li>
        <li class="breadcrumb-item active">
            Edit Program
        </li>
    </x-slot>

    <div class="row g-3">
        <div class="col-3">
            <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
                <x-slot name="header">Navigate to</x-slot>
                <x-slot name="body">
                    <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">Users</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.programs.index') }}" class="nav-link active">Programs</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.typology.index') }}" class="nav-link ">Typologies</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.syllabus-settings.index') }}" class="nav-link">Syllabus
                                Settings</a>
                        </li>
                    </ul>
                </x-slot>
            </x-real.card>
        </div>

        <div class="col-9">
            <div class="row g-3">
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12">
                            <x-real.card>
                                <x-slot name="header">
                                    Create Program Form
                                </x-slot>
                                <x-slot name="body">
                                    <x-real.form action="{{ route('admin.programs.store') }}">
                                        <x-real.input name="code" value="{{ old('code') }}">
                                            <x-slot name="label">Code</x-slot>
                                        </x-real.input>

                                        <x-real.input name="title" value="{{ old('title') }}">
                                            <x-slot name="label">Title</x-slot>
                                        </x-real.input>

                                        <x-real.input name="is_general" type="select">
                                            <x-slot name="label">Add as General Program?</x-slot>
                                            <x-slot name="options">
                                                <option {{ old('is_general') == false ? 'selected' : '' }} value="0">
                                                    No
                                                </option>
                                                <option {{ old('is_general') == true ? 'selected' : '' }} value="1">
                                                    Yes
                                                </option>
                                            </x-slot>
                                        </x-real.input>

                                        <h6 class="fw-bold mt-5">Assign A Program Dean</h6>
                                        <x-real.table>
                                            <x-slot name="headers">
                                                <th>Dean</th>
                                                <th>Is Assigned</th>
                                            </x-slot>
                                            <x-slot name="rows">
                                                @foreach ($deans as $user)
                                                    <tr>
                                                        <td>
                                                            {{ $user->name }}
                                                        </td>
                                                        <td>
                                                            <x-real.input type="radio" name="program_dean[]"
                                                                value="{{ $user->id }}">
                                                            </x-real.input>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </x-slot>
                                        </x-real.table>

                                        <x-slot name="submit">
                                            <x-real.btn type="submit" :btype="'solid'" :size="'lg'">Confirm
                                            </x-real.btn>
                                        </x-slot>
                                    </x-real.form>
                                </x-slot>
                            </x-real.card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {})
        </script>
    @endsection
</x-app-layout>
