<td class="td-actions bg-white">
    <div class="row row-cols-1 g-2">
        @isset($resource->getMedia()[0])
            <x-button.download-single-resource :passover="$resource->id">
            </x-button.download-single-resource>
        @endisset

        @if (!$resource->pivot->is_important)
            <x-submit.update-importantresource-hidden :passover="$resource->id">
            </x-submit.update-importantresource-hidden>
        @else
            <x-submit.update-remove-importantresource-hidden :passover="$resource->id">
            </x-submit.update-remove-importantresource-hidden>
        @endif

        @if ($resource->user_id != auth()->id())
            <x-submit.destroy-savedresource-hidden :passover="$resource->id">
            </x-submit.destroy-savedresource-hidden>
        @else
            <x-submit.destroy-resource-hidden :passover="$resource->id">
            </x-submit.destroy-resource-hidden>
        @endif
    </div>
</td>
