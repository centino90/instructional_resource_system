@props(['id' => '', 'tabpanes' => [], 'emptyMsg' => 'There are no rows'])

<div {{ $attributes->merge(['class' => 'tab-content']) }} id="tabcontent{{ $id }}">
    {{ $slot }}
</div>

{{-- <x-real.tabcontent id="''" tabpanes="''"></x-real.tabcontent> --}}
