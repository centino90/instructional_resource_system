<form {{ $attributes }} method="POST" class="p-0">
    @csrf
    @method('POST')

    @isset($title)
        <div class="my-3 mb-4">
            <div class="d-flex justify-content-center">
                <h4 class="fw-bold">{{ $title ?? null }}</h4>
            </div>

            <div class="col-10 col-sm-8 col-md-5 text-center mx-auto">
                <small>{{ $titleDescription ?? null }}</small>
            </div>
        </div>
    @endisset

    {{ $slot }}

    @isset($actions)
        <div class="row g-3">
            {{ $actions ?? null }}
        </div>
    @endisset
</form>
