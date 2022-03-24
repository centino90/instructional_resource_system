@props(['variant' => 'primary', 'defaultHeader' => false, 'vertical' => 'end', 'paddingX' => '', 'paddingY' => ''])

<div
    class="card shadow-sm
@switch($variant) @case('primary')
        @break
    @case('secondary')
        border-0
        @break
    @default @endswitch
">
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
                {{ $action }}
            @endisset
        </div>
    @endisset

    <div class="card-body px-{{$paddingX}} py-{{$paddingY}}">
        {{ $body }}
    </div>
</div>
