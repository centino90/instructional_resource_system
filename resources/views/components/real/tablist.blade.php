@props(['variant' => 'pills', 'direction' => 'vertical', 'id', 'tabs' => [], 'tabLabel' => '', 'activeId' => '', 'emptyMsg' => 'There are no rows'])



@php
$direction == 'vertical' ? ($d = 'flex-column') : ($d = 'flex-row');
@endphp

<ul {{ $attributes->merge(['class' => 'nav nav-' . $variant . ' ' . $d]) }} id="tablist{{ $id }}"
    role="tablist" aria-orientation="{{ $direction }}">

    @if ((!empty($tabs) && is_array($tabs)) || (!empty($tabs) && is_array($tabs->toArray())))
        @forelse ($tabs as $tab)
            @php
                $variant == 'pills' ? ($var = 'pill') : ($var = 'tab');
                if (!empty($activeId)) {
                    $tab->id == $activeId ? ($active = true) : ($active = false);
                } else {
                    $active = $loop->first;
                }
            @endphp

            <li class="nav-item" role="presentation">
                <x-real.tab :active=$active :variant=$var :id="$id . $loop->iteration"
                    :targetId="$id . $loop->iteration" :loop=$loop>
                    {{ $tab->$tabLabel }}
                </x-real.tab>
            </li>
        @empty
            <x-real.no-rows>
                <x-slot name="label">
                    {{ $emptyMsg }}
                </x-slot>
            </x-real.no-rows>
        @endforelse
    @else
        {{ $slot }}
    @endif
</ul>


{{-- <x-real.tablist :variant="'pills'" direction="'vertical'" id="''" tabs="'[]'" tabLabel="''" activeId="''">

</x-real.tablist> --}}
