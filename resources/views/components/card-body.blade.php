<div {{ $attributes->merge(['class' => 'card bg-transparent']) }}>
    <div class="card-body bg-white rounded">
        {{ $slot }}
    </div>
</div>
