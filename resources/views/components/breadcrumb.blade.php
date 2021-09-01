<nav {{ $attributes->merge(['class' => 'd-flex']) }} aria-label="breadcrumb">
    <ol class="breadcrumb py-0 my-0">

        {{ $slot }}

    </ol>
</nav>
