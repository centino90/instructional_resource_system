@props(['variant' => 'primary', 'defaultHeader' => false, 'vertical' => 'end'])

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
        <div class="card-header py-0 d-flex justify-content-between align-items-{{$vertical}} @if (!$defaultHeader) bg-transparent @endif">
            <h6 class="mb-0 py-3">{{ $header }}</h6>

            @isset($action)
                {{ $action }}
            @endisset
        </div>
    @endisset

    <div class="card-body">
        {{ $body }}
    </div>
</div>
