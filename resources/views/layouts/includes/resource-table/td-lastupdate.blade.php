<td class="td-lastupdate">
    {{ \Carbon\Carbon::parse($resource->updated_at)->format('M d Y') }}

    @if ($resource->users->find(auth()->id()))
        <small class="text-success fst-italic">Saved</small>
    @endif
</td>
