<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.personnels.index') }}">Personnels</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create personnel</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <a href="{{route('admin.personnels.index')}}" class="btn btn-link text-decoration-none border">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Go Back
        </a>

        <div class="d-flex bg-white p-3 mt-3 rounded shadow-sm mb-3">
            <div>
                <small class="h3 font-weight-bold">
                    {{ __('Create personnel') }}
                </small>
                <div class="col-12 col-md-5">
                    <small class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error deleniti mollitia atque illum dolores vitae, fugit itaque iusto, aliquid ut sequi. Deserunt sit consectetur sequi? Reprehenderit eligendi saepe quaerat deleniti!
                    </small>
                </div>
            </div>

            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
        <div class="my-4">
            <x-alert-success>
                {{ session()->get('success') }}

                <a href="{{ route('resources.index') }}">
                    <strong class="px-2">Go see the resources now?</strong>
                </a>
            </x-alert-success>
        </div>
    @endif

    @if ($errors->any())
    <x-alert-danger class="my-4">
        <span>Look! You got {{$errors->count()}} error(s)</span>
    </x-alert-danger>
    @endif

    <div class="row mt-4">
        <div class="col-12">
            <x-card-body class="tab-content rounded-0 rounded-bottom border border-top-0 shadow-sm">
                <x-form-post action="{{ route('admin.personnels.store') }}" id="personnelForm">
                    <div class="col-12 col-md-3">
                        <x-label>Name *</x-label>
                        <x-input name="name"></x-input>
                        <x-input-error :for="'name'"></x-input-error>
                    </div>

                    <div class="col-12 col-md-3">
                        <x-label>Program *</x-label>
                        <x-input-select name="program">
                            @foreach ($programs as $program)
                            <option value="{{$program->id}}">{{$program->title}}</option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :for="'program'"></x-input-error>
                    </div>

                    <div class="col-12 col-md-3">
                        <x-label>Role *</x-label>
                        <x-input-select name="role">
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :for="'role'"></x-input-error>
                    </div>

                    <div class="col-12 col-md-3 mt-3">
                        <x-button type="submit" :class="'btn-primary'">Create</x-button>
                    </div>
                </x-form-post>
            </x-card-body>
        </div>
    </div>

    @section('script')
        <script>
            (function($) {
                // alert('yes')
            })(jQuery);
        </script>
    @endsection
</x-app-layout>
