<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Resources</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show syllabus</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex my-4">
            <small class="h4 font-weight-bold">
                {{ __('Show syllabus') }}
            </small>

            {{-- HEADER ACTIONS SECTION --}}
            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
        <div class="my-4">
            <x-alert-success>
                {{ session()->get('success') }}
            </x-alert-success>
        </div>
    @endif

    {{-- CONTENT SECTION --}}
    <div class="row">
        <div class="col-12 mb-3">
            hello world
        </div>

        {{-- HIDDEN FORMS --}}
        <x-form.store-savedresource-hidden></x-form.store-savedresource-hidden>
    </div>

    @section('script')
        <script>
            $('.storeSavedresourceHiddenSubmit').click(function() {
                let form = $($(this).attr('data-form-target'))
                let passoverData = $(this).attr('data-passover')
                let input = form.find('input[name="resource_id"]')
                input.val(passoverData)

                form.submit()
            })

            $('#download-bulk').click(function(e) {
                e.preventDefault()
                let downloadBtn = $(this)
                let table = $(this.closest('table'))
                let checkboxes = table.find('th:first-child .check, td:first-child .check')
                console.log(checkboxes)
                $(checkboxes).each(function() {
                    if ($(this).is(":checked")) {
                        $(this).closest('th, td').find(':hidden').removeAttr('disabled')
                    } else {
                        $(this).closest('th, td').find(':hidden').attr('disabled', 'disabled')
                    }
                })

                table.closest('form').submit();
                checkboxes.prop('checked', false);
                downloadBtn.removeClass('loading')
            })

            $('#check-all').change(function(e) {
                let table = $(this.closest('table'))
                let checkboxes = table.find('td:first-child .check')

                if ($(this).is(':checked')) {
                    checkboxes.prop('checked', true)
                } else {
                    checkboxes.prop('checked', false)
                }
            })

            $('.check').change(function(e) {
                let table = $(this.closest('table'))
                let downloadBtn = table.find('#download-bulk')
                let checkboxes = table.find('td:first-child .check')
                let currentCheckbox = $(this)

                if (checkboxes.filter(':checked').length > 0) {
                    downloadBtn.removeClass('disabled')
                } else {
                    downloadBtn.addClass('disabled')
                }
            })
        </script>
    @endsection
</x-app-layout>
