@props(['active'])

@php
$classes = $active ?? false ? 'syllabus-tabs nav-link active font-weight-bolder px-4 py-3' : 'syllabus-tabs nav-link px-4 py-3';
@endphp

<li class="nav-item">
    <a {{ $attributes->merge(['class' => $classes]) }}>

        {{ $slot }}
    </a>
</li>
