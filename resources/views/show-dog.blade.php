<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dogs.index') }}">Dog</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show dog</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Show dog') }}
            </small>

            {{-- HEADER ACTIONS SECTION --}}
            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
        <div class="my-4">
            <x-alert-success>
                {{ session()->get('success') }}

                <a href="{{ route('dogs.index') }}">
                    <strong class="px-2">Go see the dogs now?</strong>
                </a>
            </x-alert-success>
        </div>
    @endif

    {{-- CONTENT SECTION --}}
    <div class="row">
        <div class="col-12">
            @foreach ($dog->course_description['paragraphs'] as $row)
                {{ $row }}
                <br>
            @endforeach
        </div>
    </div>
</x-app-layout>
