@props(['variant' => 'primary', 'defaultHeader' => false, 'vertical' => 'end', 'paddingX' => '', 'paddingY' => ''])

@php
$cardClass = collect(['card', 'shadow-sm']);
@endphp

@switch($variant)
    @case('primary')
    @break

    @case('secondary')
        @php $cardClass->push('border-0') @endphp
    @break

    @default
@endswitch

<div {{ $attributes->merge([
    'class' => $cardClass->join(' '),
]) }}>
    @isset($header)
        <div
            class="card-header py-0 d-flex justify-content-between align-items-{{ $vertical }} @if (!$defaultHeader) bg-transparent @endif">
            <header class="py-3">
                <h6 class="my-0 py-0">{{ $header }}</h6>

                @isset($label)
                    <small class="text-muted">{{ $label }}</small>
                @endisset
            </header>

            @isset($action)
                <div class="hstack gap-2 align-items-{{ $vertical }}">
                    {{ $action }}
                </div>
            @endisset
        </div>
    @endisset

    <div class="card-body px-{{ $paddingX }} py-{{ $paddingY }} h-10=">
        {{ $body }}
    </div>
</div>
