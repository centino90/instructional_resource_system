@props(['class' => '', 'id', 'target'])

<li class="nav-item " role="presentation">
    <button
        {{ $attributes->merge(['id' => $id, 'data-bs-target' => $target, 'class' => 'rounded-pill nav-link p-0 ' . $class]) }}
        data-bs-toggle="pill" type="button" role="tab" style="width: 2rem; height:2rem;">

        {{ $slot }}
        <span class="position-absolute bottom-50 mb-2 pe-2 translate-middle form-text">{{ __('Chapter') }}</span>
    </button>
</li>
