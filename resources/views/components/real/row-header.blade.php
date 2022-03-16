<header class="overflow-hidden mb-3">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h5 class="text-truncate my-0 rounded">{{$title}}</h5>

            @isset($subheader)
                <small class="text-muted">{{ $subheader }}</small>
            @endisset
        </div>

        {{ $slot }}
    </div>
</header>

