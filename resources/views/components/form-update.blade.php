<form {{ $attributes }} method="POST" class="mx-0 px-0">
    @csrf
    @method('PUT')

    @if (isset($title) || isset($titleDescription))
        <div class="my-3 mb-4">
            <div class="d-flex justify-content-center">
                <h4 class="fw-bold">{{ $title ?? '' }}</h4>
            </div>

            <div class="col-10 col-sm-8 col-md-5 text-center mx-auto">
                <small>{{ $titleDescription ?? '' }}</small>
            </div>
        </div>
    @endif

    {{ $slot }}

    @isset($actions)
        <div class="mb-3">
            {{ $actions }}
        </div>
    @endisset
</form>
