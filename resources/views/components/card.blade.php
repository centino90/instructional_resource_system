@props(['header' => ''])

<div {{ $attributes->merge(['class' => 'card bg-transparent']) }}>
    @empty($header)

    @else
        <h5 class="mb-3">{{ $header }}</h5>
    @endempty

    <div class="card-body bg-white rounded shadow-sm">
        {{ $slot }}
    </div>
</div>
