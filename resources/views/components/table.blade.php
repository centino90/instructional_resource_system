<table {{ $attributes->merge(['class' => 'table table-hover align-middle']) }}>
    <thead>
        <tr>
            {{ $thead }}
        </tr>
    </thead>

    <tbody class="bg-white">
        {{ $slot }}
    </tbody>
</table>
