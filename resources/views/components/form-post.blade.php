<form {{ $attributes }} method="POST">
    @csrf
    @method('POST')

    <div class="my-3 mb-4">
        <div class="d-flex justify-content-center">
            <h4 class="fw-bold">{{ $title }}</h4>
        </div>

        <div class="col-10 col-sm-8 col-md-5 text-center mx-auto">
            <small>{{ $titleDescription }}</small>
        </div>
    </div>

    {{ $slot }}

    <div class="row g-3 mb-3">
        {{ $actions }}
    </div>
</form>
