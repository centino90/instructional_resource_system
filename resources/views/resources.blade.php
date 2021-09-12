<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Resources</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Resources') }}
            </small>

            <div class="ms-auto">
                <a href="{{ route('resources.create') }}" class="btn btn-success">
                    {{ __('Create resource') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="my-4">
        @if (session()->exists('success'))
        <x-alert-success class="mb-3">
            {{ session()->get('success') }}

            <a href="{{ route('resources.create') }}"><strong class="px-2">Go back to creating
                    resource?</strong></a>
        </x-alert-success>
        @endif

        <x-alert-warning>
            You still have not created a single resource this semester!
            <a href="#"><strong class="px-2">Create now?</strong></a>
        </x-alert-warning>
    </div>

    <div class="row">
        <div class="col-12">
            <x-card-body>
                <x-table class="">
                    <x-slot name="thead">
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </x-slot>

                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>

                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>

                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>

                    </tr>
                </x-table>
 
            </x-card-body>
        </div>


        </tr>
    </div>
</x-app-layout>