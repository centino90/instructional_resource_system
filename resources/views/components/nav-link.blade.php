@props(['active', 'href' => '#', 'routeParams' => false])

@php
// dd(Route::currentRouteName());
// dd(route('resources.create')->named('resources.create'));
$active = $active ?? explode('/', Route::current()->uri)[0] == explode('.', $href)[0] ? true : false;

$classes = $active ?? false ? 'nav-link active font-weight-bolder' : 'nav-link';
@endphp

<li class="nav-item">
    <a {{ $attributes->merge(['class' => $classes, 'href' => route($href, $routeParams)]) }}>

        {{ $slot }}
    </a>
</li>
