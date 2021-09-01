<div {{ $attributes->merge(['class' => 'nav-progress position-relative']) }} id="createResourceTablist">
    <div class="progress" style="height: 2px;">
        <div class="progress-bar" role="progressbar" style="width: 0%;"></div>
    </div>

    <div class="position-absolute top-50 start-50 translate-middle w-100">
        <ul class="nav nav-pills justify-content-between" role="tablist">

            {{ $slot }}

        </ul>
    </div>
</div>
