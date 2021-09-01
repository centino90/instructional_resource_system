@props(['active'])

@php
$classes = $active ?? false ? 'tab-pane fade show active' : 'tab-pane fade';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="tabpanel">
    <h5 class="my-3">{{ $title }}</h5>

    {{ $slot }}
</div>
