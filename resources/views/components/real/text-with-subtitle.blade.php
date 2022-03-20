@props(['elementTag' => 'h6'])

<div {{ $attributes->merge(['class' => 'overflow-hidden']) }}>
    <{{$elementTag}} class="text-truncate d-block my-0">
        {{ $text }}
    </{{$elementTag}}>

    @isset($subtitle)
    <small class="text-muted">{{ $subtitle }}</small>
    @endisset
</div>
