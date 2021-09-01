<form {{ $attributes }} method="POST">
    @csrf
    @method('DELETE')

    <h4 class="my-3">{{ $title }}</h4>

    {{ $slot }}

    <div class="mb-3">
        {{ $actions }}
    </div>
</form>
