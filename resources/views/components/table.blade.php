<table {{ $attributes->merge(['class' => 'table']) }}>
    <thead>
        <tr>
            {{ $thead }}
        </tr>
    </thead>

    <tbody>
        {{ $slot }}
    </tbody>
</table>
