<form action="{{ route('resources.bulkDownload') }}" method="post" class="p-0">
    @csrf

    <table {{ $attributes->merge(['class' => 'table table-striped caption-top']) }}>
        <caption>
            <x-button class="btn-primary disabled" type="submit" id="download-bulk">
                Download selected rows
            </x-button>
        </caption>

        <thead>
            <tr>
                <th class="th-checks">
                    <x-input-check :label="'select all'" name="check-all" class="check"></x-input-check>
                </th>
                <th class="th-file">File</th>
                <th class="th-course">Course</th>
                <th class="th-lastupdate">Last update</th>
                <th class="th-actions"></th>
            </tr>
        </thead>

        <tbody>
            <tr class="d-none">
                <form action="#" method="post"></form>
            </tr>

            {{ $slot }}
        </tbody>
    </table>
</form>
{{-- </x-form-post> --}}

{{-- <td>
                            {{ \Carbon\Carbon::parse($resource->updated_at)->format('M d Y') }}
                            @if ($resource->users->find(auth()->id()) && \App\Models\ResourceUser::orderByDesc('updated_at')->first()->batch_id != $resource->users()->first()->pivot->batch_id)
                                <small class="text-success fst-italic">Saved</small>
                            @elseif($resource->users->find(auth()->id()) &&
                                \App\Models\ResourceUser::orderByDesc('updated_at')->first()->batch_id ==
                                $resource->users()->first()->pivot->batch_id)
                                <small class="text-success fst-italic">Just got saved</small>
                            @endif
                        </td> --}}
