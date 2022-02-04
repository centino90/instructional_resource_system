<div {{ $attributes->merge(['class' => 'card bg-transparent']) }}>
    <div class="card-body bg-white rounded shadow-sm">
        {{ $slot }}
    </div>
</div>
