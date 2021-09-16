<table {{ $attributes->merge(['class' => 'table align-middle']) }}>
    <thead>
        <tr>
            {{ $thead }}
        </tr>
    </thead>

    <tbody>
        {{ $slot }}
    </tbody>
</table>
