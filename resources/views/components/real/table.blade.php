@props(['size' => 'table-sm', 'variant' => ''])

<table {{ $attributes->merge(['class' => 'w-100 table align-middle table-hover ' . ' ' . $variant . ' ' . $size]) }}>
    <thead class="text-muted">
        <tr>
            {{ $headers }}
        </tr>
    </thead>
    <tbody>
        {{ $rows }}
    </tbody>

    @isset($footers)
        <tfoot class="text-muted">
            <tr>
                {{ $footers }}
            </tr>
        </tfoot>
    @endisset
</table>
