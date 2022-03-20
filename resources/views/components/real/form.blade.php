@props(['method' => 'POST'])

<form {{ $attributes->merge(['class' => 'mx-0 px-0']) }} method="POST">
    @csrf
    @method($method)

    @isset($submit)
        {{ $submit }}
    @endisset
</form>
