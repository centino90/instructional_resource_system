@props(['active', 'href' => '#', 'routeParams' => false])

@php
$active = $active ?? explode('/', Route::current()->uri)[0] == explode('.', $href)[0] ? true : false;

$classes = $active ?? false ? 'nav-link active font-weight-bolder' : 'nav-link';
@endphp

<li class="nav-item">
    <a {{ $attributes->merge(['class' => $classes, 'href' => $href != '#' ? route($href, $routeParams) : '#']) }}>

        {{ $slot }}
    </a>
</li>
