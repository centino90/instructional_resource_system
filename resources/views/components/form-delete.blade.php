<form {{ $attributes }} method="POST">
    @csrf
    @method('DELETE')

    @isset($title)
        <h4 class="my-3">{{ $title ?? '' }}</h4>
    @endisset

    {{ $slot }}

    @isset($actions)
        <div class="mb-3">
            {{ $actions ?? '' }}
        </div>
    @endisset
</form>
