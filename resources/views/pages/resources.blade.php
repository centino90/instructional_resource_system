<x-app-layout>
    <x-slot name="header">
        Resources
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('dashboard') }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Resources</li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <x-real.card>
                <x-slot name="header">Resources</x-slot>
                <x-slot name="body">
                    {!! $dataTable->table(['class' => 'table table-hover w-100 align-middle']) !!}
                </x-slot>
            </x-real.card>
        </div>
    </div>
    </div>


    @section('script')
        {!! $dataTable->scripts() !!}
    @endsection
</x-app-layout>
