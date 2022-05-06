@props(['errors'])

@if ($errors->any())
    <div {!! $attributes->merge(['class' => 'alert alert-danger']) !!} role="alert">
        <div class="text-danger">{{ __('Whoops! Something went wrong.') }}</div>

        <small>You got {{$errors->count()}} error(s). Please check them out.</small>
    </div>
@endif
