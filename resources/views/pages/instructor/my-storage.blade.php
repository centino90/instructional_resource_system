<x-app-layout>
    <x-slot name="header">
        @if (auth()->id() === $user->id)
            My storage
        @else
            {{ $user->username . "'\s'" . ' storage' }}
        @endif
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">
            @if (auth()->id() === $user->id)
                My storage
            @else
                {{ $user->username . "'\s'" . ' storage' }}
            @endif
        </li>
    </x-slot>

    <div class="row">
        <div class="col-12" style="height: 600px">
            <div class="mt-5" id="fm"></div>
        </div>
    </div>

    @section('style')
        <link href="{{ asset('vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    @endsection
</x-app-layout>
