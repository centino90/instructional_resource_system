<td class="td-checks">
    <span class="d-flex">
        <x-input-check class="check" name="check-{{ $loop->iteration }}" :label="$loop->iteration">
        </x-input-check>

        <x-input hidden disabled name="resource_no[]" :value="$resource->id"></x-input>
    </span>
</td>
