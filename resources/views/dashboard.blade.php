<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item invisible">Dashboard Calo</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold align-middle">
                {{ __('Home') }}
            </small>
        </div>
    </x-slot>

    @if (session()->exists('status'))
        <div class="mt-4">
            <x-alert-success>
                <strong>Welcome. </strong> {{ session()->get('status') }}
            </x-alert-success>
        </div>
    @endif

    <div class="row row-cols-1 g-3 mt-3">
        @forelse ($yearLevels as $yearLevel)
            <div class="col">
                Year {{ array_keys($yearLevels->toArray())[$loop->index] }}
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    @forelse ($yearLevel as $semester)
                        <x-card-body>
                            Semester {{ array_keys($yearLevel->toArray())[$loop->index] }}
                            <div class="col">
                                <x-table class="table-sm table-hover">
                                    <x-slot name="thead">
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Term</th>
                                        <th></th>
                                    </x-slot>

                                    @forelse ($semester as $course)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <a href="{{ route('courses.show', $course->id) }}"
                                                    class="btn btn-link" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="go to this course">
                                                    {{ $course->code }}
                                                </a>
                                            </td>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ $course->term }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <span class="btn btn-link" id="view-resources"
                                                        data-bs-toggle="modal" data-bs-target="#viewResourcesModal"
                                                        data-coursetitle="{{ $course->title }}"
                                                        data-courseid="{{ $course->id }}">View
                                                        resources</span>

                                                    <form action="{{ route('resources.downloadAllByCourse') }}"
                                                        method="post">
                                                        @csrf
                                                        <x-input type="hidden" name="course_id"
                                                            value="{{ $course->id }}">
                                                        </x-input>

                                                        <span class="btn btn-link" onclick="
                                                            this.closest('form').submit()">
                                                            Download all
                                                        </span>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        no course exist
                                    @endforelse


                                </x-table>
                            </div>
                        </x-card-body>
                    @empty
                        there are no year levels
                    @endforelse
                </div>
            </div>
        @empty
            There are no courses yet
        @endforelse
    </div>

    <div class="modal" id="viewResourcesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Course Resources</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <small>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse perferendis dignissimos ullam
                        vitae hic doloribus!</small>
                    <form action="{{ route('resources.downloadAllByCourse') }}" method="post">
                        @csrf
                        <ul class="resource-list nav flex-column mt-3">

                        </ul>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary submit">Download all</button>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $('.view-resources').click(function(e) {
                e.preventDefault();
            })

            $('#viewResourcesModal').on('shown.bs.modal', function(event) {
                let modal = $(event.target)
                let triggerButton = $(event.relatedTarget)
                let dataCourseTitle = triggerButton.attr('data-coursetitle')
                let modalTitle = modal.find('.modal-title')
                let dataCourseId = triggerButton.attr('data-courseid')
                let formRoute = '{{ route('resources.getResourcesJson') }}'
                let resourceList = modal.find('.resource-list')
                let downloadRoute = '{{ route('resources.download', '') }}'
                let modalForm = modal.find('form')
                let downloadSubmit = modal.find('button.submit')

                modalTitle.html(`View <b>${dataCourseTitle}'s</b> Resources`)

                $.ajax({
                    url: `${formRoute}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_id: dataCourseId,
                    },
                    beforeSend: function() {
                        let spinner = document.createElement('div')
                        $(spinner).addClass('spinner-border text-primary')
                        downloadSubmit.addClass('disabled')

                        resourceList.append(spinner)
                    },
                    success: function(response) {
                        resourceList.find('.spinner-border').remove()
                        downloadSubmit.removeClass('disabled')

                        if (response.resources.length <= 0) {
                            let listItem = document.createElement('li')
                            $(listItem).addClass('nav-item d-flex')

                            let alert = document.createElement('div')
                            $(alert).addClass('alert alert-warning')
                            $(alert).attr('role', `alert`)
                            $(alert).text('There are no resources in this course yet')

                            listItem.append(alert)
                            resourceList.append(listItem)
                            downloadSubmit.addClass('disabled')

                            return
                        }

                        $.each(response.resources, function(key, value) {
                            let listItem = document.createElement('li')
                            $(listItem).addClass('nav-item d-flex border-bottom')
                            $(listItem).text(value.file_name)

                            let downloadLink = document.createElement('a')
                            $(downloadLink).addClass('ms-auto')
                            $(downloadLink).attr('href', `${downloadRoute}/${value.model_id}`)
                            $(downloadLink).text('download')

                            let hiddenInput = document.createElement('input')
                            $(hiddenInput).attr('name', 'course_id')
                            $(hiddenInput).attr('type', 'hidden')
                            $(hiddenInput).val(dataCourseId)

                            listItem.append(downloadLink)
                            listItem.append(hiddenInput)
                            resourceList.append(listItem)
                        })

                        downloadSubmit.click(function() {
                            modalForm.submit()
                            $(this).removeClass(['disabled', 'loading'])
                        })
                    },
                    error: function() {
                        alert('error')
                    },
                })
            })

            $('#viewResourcesModal').on('hidden.bs.modal', function(event) {
                let modal = $(event.target)
                let triggerButton = $(event.relatedTarget)
                let dataCourseTitle = triggerButton.attr('data-coursetitle')
                let modalTitle = modal.find('.modal-title')
                let dataCourseId = triggerButton.attr('data-courseid')
                let formRoute = '{{ route('resources.getResourcesJson') }}'
                let resourceList = modal.find('.resource-list')
                let downloadSubmit = modal.find('button.submit')

                downloadSubmit.removeClass('disabled')
                resourceList.find('li').remove()
            })
        </script>
    @endsection
</x-app-layout>
