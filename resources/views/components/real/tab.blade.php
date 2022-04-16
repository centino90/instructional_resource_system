@props(['active' => false, 'hasActive' => false, 'variant' => 'pill', 'id' => '', 'loop', 'targetId'])

@php
if ($active == true) {
    $classActive = ' active ';
} else {
    $classActive = '';
}

@endphp

<li class="nav-item p-0">
    @isset($loop)
        <a {{ $attributes->merge(['class' => 'nav-link' . $classActive]) }} id="tab{{ $id }}"
            data-bs-toggle="{{ $variant }}" data-bs-target="#tabpane{{ $targetId ?? $id }}" type="button" role="tab"
            aria-controls="tabpane{{ $targetId ?? $id }}" aria-selected="{{ $loop->first ? true : false }}">
            {{ $slot }}
        </a>
    @else
        <a {{ $attributes->merge(['class' => 'nav-link' . $classActive]) }} id="tab{{ $id }}"
            data-bs-toggle="{{ $variant }}" data-bs-target="#tabpane{{ $targetId ?? $id }}" type="button" role="tab"
            aria-controls="tabpane{{ $targetId ?? $id }}">
            {{ $slot }}
        </a>
    @endisset
</li>

{{-- <x-real.tab active="'false'" hasActive="'false'" variant="'pill'" id="''" loop="''" targetId="''">

</x-real.tab> --}}
