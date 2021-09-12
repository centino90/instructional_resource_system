<td class="td-actions bg-white">
    <div class="row row-cols-1 g-2">
        @isset($resource->getMedia()[0])
            <x-button.download-single-resource :passover="$resource->id"></x-button.download-single-resource>
        @endisset

        @if (!\App\Models\ResourceUser::where('resource_id', $resource->id)->where('user_id', auth()->id())->exists())

            <x-submit.store-savedresource-hidden :passover="$resource->id">
            </x-submit.store-savedresource-hidden>
        @endif
    </div>
</td>
