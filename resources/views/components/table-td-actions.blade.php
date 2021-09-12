<td class="td-actions bg-white">
    <div class="row row-cols-1 g-2">
        @isset($resource->getMedia()[0])
            <a href="{{ route('resources.download', $resource->id) }}" class="btn btn-primary col">Download</a>
        @endisset

        @if (!$resource->users->find(auth()->id()))
            <x-form-post action="{{ route('saved-resources.store') }}" class="px-0 col" method="post">
                <x-input value="{{ $resource->id }}" name="resource_id" hidden>
                </x-input>

                <x-button class="btn-secondary form-control" type="submit">Save
                </x-button>
            </x-form-post>
        @endif
    </div>
</td>
