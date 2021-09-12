@props(['passover' => ''])

<a {{ $attributes }} href="{{ route('resources.download', $passover) }}" class="btn btn-primary col">
    Download
</a>
