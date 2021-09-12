<td class="td-file">
    <div class="text-muted">
        <span class="text-muted">
            Submitted by
            @if ($resource->user_id != auth()->id())
                <strong>
                    {{ ucwords($resource->users->last()->name ?? 'unknown user') }}
                </strong>
            @else
                <strong>
                    You
                </strong>
            @endif
        </span>

        @if ($resource->is_syllabus)
            | <strong class="text-primary">
                <a href="{{ route('syllabi.show', $resource->id) }}">Syllabus</a>
            </strong>
        @endif

        @if ($resource->getMedia()->first())
            | <a href="{{ route('resources.download', $resource->id) }}">
                <small>Download</small>
            </a>
        @endif

        @if (!$resource->approved_at)
            | <span class="badge rounded-pill bg-warning text-dark">
                for approval
            </span>
        @endif

        <small
            class="badge rounded-pill bg-success mx-1">{{ $resource->batch_id == $resources->first()->batch_id ? 'latest' : '' }}</small>

        {{-- TEMPORARY --}}
        {{ $resource->course->program_id == auth()->user()->program_id ? '' : 'Do not belong here!' }}
    </div>

    {{ $resource->getMedia()->first()->file_name ?? 'not available' }}
</td>
