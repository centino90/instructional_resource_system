@props(['id' => '', 'loop', 'active' => false])

@php
if ($active) {
    $classActive = ' show active ';
} else {
    $classActive = '';
}
@endphp

@isset($loop)
    <div {{ $attributes->merge(['class' => 'tab-pane fade ' . $classActive]) }}
        id="tabpane{{ $id }}{{ $loop->iteration }}" role="tabpanel"
        aria-labelledby="tab{{ $id }}{{ $loop->iteration }}">
        {{ $slot }}
    </div>
@else
    <div {{ $attributes->merge(['class' => 'tab-pane fade ' . $classActive]) }} id="tabpane{{ $id }}"
        role="tabpanel" aria-labelledby="tab{{ $id }}">
        {{ $slot }}
    </div>
@endisset


{{-- <x-real.tabpane id="" loop="" active=""></x-real.tabpane> --}}
