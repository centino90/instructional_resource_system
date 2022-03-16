@props(['size' => 'sm', 'variant' => ''])

<table class="table align-middle table-hover {{$variant}} {{ $size }}">
    <thead class="text-muted">
        <tr>
            {{ $headers }}
        </tr>
    </thead>
    <tbody>
        {{ $rows }}
    </tbody>
</table>
