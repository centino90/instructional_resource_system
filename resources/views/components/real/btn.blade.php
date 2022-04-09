@props(['tag' => 'button', 'btype' => 'outline', 'size' => 'md', 'variant' => 'primary-light', 'icon', 'iconSize' => 'sm'])

@php
switch ($iconSize) {
    case 'sm':
        $iconSize = '18';
        break;
    case 'md':
        $iconSize = '26';
        break;
    case 'lg':
        $iconSize = '34';
        break;

    default:
}

if (sizeof(explode('-', $variant)) >= 2) {
    [$variantBg, $variantTxt] = explode('-', $variant);
}
@endphp

@if ($btype == 'outline')
    <{{$tag}}
        {{ $attributes->merge(['class' => "btn text-nowrap border fw-bold btn-light text-{$variantBg} btn-{$size}"]) }}>
        @isset($icon)
            <span class="material-icons md-{{ $iconSize }} align-middle"> {{ $icon }} </span>
        @endisset {{$slot}}
    </{{$tag}}>
@elseif($btype == 'solid')
    <{{$tag}}
        {{ $attributes->merge(['class' => "btn text-nowrap text-{$variantTxt} btn-{$size} btn-{$variantBg}"]) }}>
        @isset($icon)
            <span class="material-icons md-{{ $iconSize }} align-middle"> {{ $icon }} </span>
        @endisset {{$slot}}
    </{{$tag}}>
@endif
