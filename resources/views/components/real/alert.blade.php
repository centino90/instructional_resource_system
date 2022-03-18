@props(['variant' => 'success'])

<div {{ $attributes->merge(['class' => 'hstack align-items-start gap-3 alert alert-dismissible my-0 alert-' . $variant]) }} role="alert">
    @switch($variant)
        @case('success')
            <span class="material-icons align-middle">
                task_alt
            </span>
        @break

        @case('danger')
            <span class="material-icons align-middle">
                error
            </span>
        @break

        @case('warning')
            <span class="material-icons align-middle">
                warning
            </span>
        @break

        @case('info')
            <span class="material-icons align-middle">
                info
            </span>
        @break

        @default
            <span class="material-icons align-middle">
                task_alt
            </span>
    @endswitch


    {{ $slot }}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
