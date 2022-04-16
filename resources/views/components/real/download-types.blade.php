@props(['resource', 'mediaFromUri' => '', 'btnSize' => 'md'])

@php
$media = $resource->current_media_version;
$resourceExt = pathinfo($media->getPath(), PATHINFO_EXTENSION);
if ($mediaFromUri && !empty(trim($mediaFromUri))) {
    $resourceExt = pathinfo(
        $resource
            ->media()
            ->where('id', $mediaFromUri)
            ->firstOrFail()
            ->getPath(),
        PATHINFO_EXTENSION,
    );
}
@endphp

<x-real.form action="{{ route('resources.downloadOriginal', $media) }}">
    <x-slot name="submit">
        <x-real.btn :size="$btnSize" type="submit" class="w-100 no-loading">Download</x-real.btn>
    </x-slot>
</x-real.form>
@if (in_array($resourceExt, config('app.pdf_convertible_filetypes')))
    <x-real.form action="{{ route('resources.downloadAsPdf', $media) }}">
        <x-slot name="submit">
            <x-real.btn :size="$btnSize" :variant="'danger-light'" type="submit" class="w-100 no-loading">Download as PDF</x-real.btn>
        </x-slot>
    </x-real.form>
@endif
@if (in_array($resourceExt, ['doc', 'docx', 'pdf']))
    <x-real.form action="{{ route('resources.downloadAsHtml', $media) }}">
        <x-slot name="submit">
            <x-real.btn :size="$btnSize" :variant="'success-light'" type="submit" class="w-100 no-loading">Download as HTML</x-real.btn>
        </x-slot>
    </x-real.form>
@endif
