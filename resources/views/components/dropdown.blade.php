@props(['id' => 'navbarDropdown'])

<li class="nav-item btn-group dropdown">
    <a id="{{ $id }}" {!! $attributes->merge(['class' => 'nav-link dropdown-toggle']) !!} role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </a>

    <div class="dropdown-menu animate slideIn" aria-labelledby="{{ $id }}">
        {{ $content }}
    </div>
</li>
