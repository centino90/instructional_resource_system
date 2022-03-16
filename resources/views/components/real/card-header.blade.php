<header class="pb-2 overflow-hidden border-bottom mb-3">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h6 class="text-truncate d-block my-0 fw-bolder">{{ $title }}</h6>

            @isset($subheader)
                <small class="text-muted">{{ $subheader }}</small>
            @endisset
        </div>

        {{ $slot }}
    </div>
</header>
