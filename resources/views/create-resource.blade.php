<x-app-layout>
    <x-slot name="header">
        <div class="card bg-transparent mt-4">
            <div class="card-body p-0">
                <div class="d-flex">
                    <small class="h4 font-weight-bold">
                        {{ __('Create resource') }}
                    </small>

                    {{-- HEADER ACTIONS SECTION --}}
                    <div class="ms-auto">

                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ALERTS SECTION --}}
    @if (session()->exists('success'))
        <div class="my-4 card bg-transparent">
            <div class="my-0 alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 26" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-alert-circle me-1">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>

                {!! session()->get('success') !!}

                <a href="{{ route('resources.index') }}"><strong class="px-2">Go see the resources now?</strong></a>
            </div>
        </div>
    @endif

    {{-- CONTENT SECTION --}}
    <h6 class="mt-4 mb-0">
        <ul class="nav nav-tabs mt-3" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('resources.create') }}"
                    class="nav-link px-4 py-3 {{ $currentTab != 'syllabus' ? 'active' : '' }}"
                    id="home-tab">Regular</a>
            </li>

            <li class="nav-item" role="presentation">
                <a href="{{ route('resources.create', 'tab=syllabus') }}"
                    class="nav-link px-4 py-3 {{ $currentTab == 'syllabus' ? 'active' : '' }}"
                    id="profile-tab">Syllabus</a>
            </li>
        </ul>
    </h6>
    <div class="row">
        <div class="col-12">
            <div class="card rounded-0 rounded-bottom border border-top-0 shadow-sm">
                <div class="card-body tab-content">

                    @if ($currentTab == 'syllabus')
                        <form action="{{ route('resources.store') }}" method="post">
                            @csrf
                            <h5 class="my-3">Syllabus</h5>

                            <div class="p-2 mt-5 mb-4">
                                <div class="position-relative">
                                    <div class="progress" style="height: 2px;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                    </div>

                                    <div class="position-absolute top-50 start-50 translate-middle w-100">
                                        <ul class="nav nav-pills justify-content-between" id="createResourceTablist"
                                            role="tablist">
                                            <x-rounded-pill-button :class="'active'" :id="'pills-home-tab'"
                                                :target="'#pills-home'">
                                                {{ __('1') }}
                                            </x-rounded-pill-button>

                                            <x-rounded-pill-button :id="'pills-profile-tab'" :target="'#pills-profile'">
                                                {{ __(' 2') }}
                                            </x-rounded-pill-button>

                                            <x-rounded-pill-button :id="'pills-contact-tab'" :target="'#pills-contact'">
                                                {{ __(' 3') }}
                                            </x-rounded-pill-button>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <h5 class="my-3"> {{ __('Chapter 1') }}</h5>

                                    <div class="mb-3">
                                        <x-select name="course_id" :label="'Course'">
                                            <option value="">choose a course</option>
                                            <option value="1">choose a course1</option>
                                            <option value="2">choose a course2</option>
                                            <option value="3">choose a course3</option>
                                        </x-select>
                                        <x-input-error :for="'course_id'"></x-input-error>
                                    </div>

                                    <div class="mb-3">
                                        <x-input type="text" :name="'resource_type'" :label="'Resource type'">
                                        </x-input>
                                        <x-input-error :for="'resource_type'"></x-input-error>
                                    </div>

                                    <div class="mb-3">
                                        <x-input type="file" :name="'file'" :label="'File'"></x-input>
                                        <x-input-error :for="'file'"></x-input-error>
                                    </div>

                                    <div class="mb-3">
                                        <x-textarea type="text" :name="'description'" :label="'Description'">
                                        </x-textarea>
                                        <x-input-error :for="'description'"></x-input-error>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <h5 class="my-3">Chapter 2</h5>
                                </div>

                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <h5 class="my-3">Chapter 3</h5>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('resources.store') }}" method="post">
                            @csrf
                            <h5 class="my-3">Regular</h5>

                            <div class="mb-3">
                                <x-input :name="'resource_type'" :label="'Resource type'"></x-input>

                                <x-input-error :for="'resource_type'"></x-input-error>
                            </div>

                            <div class="mb-3">
                                <x-input :type="'file'" :name="'file'" :label="'File'"></x-input>

                                <x-input-error :for="'file'"></x-input-error>
                            </div>
                            <div class="mb-3">
                                <x-select :name="'course_id'" :label="'Course'">
                                    <option value="">choose a course</option>
                                    <option value="1">choose a course 1</option>
                                    <option value="2">choose a course 2</option>
                                    <option value="3">choose a course 3</option>
                                    <option value="4">choose a course 4</option>
                                </x-select>

                                <x-input-error :for="'file'"></x-input-error>
                            </div>

                            <div class="mb-3">
                                <x-textarea :name="'description'" :label="'Description'"></x-textarea>

                                <x-input-error :for="'description'"></x-input-error>
                            </div>

                            <div class="mb-3">
                                <x-input-check :name="'check_stay'" :label="'Check to stay after submit'" checked>
                                </x-input-check>
                            </div>

                            <div class="mb-3">
                                <x-button :type="'submit'" class="btn-primary me-3">Create</x-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @section('script')
        <script>
            let progressbar = document.querySelector('[role="progressbar"]')
            let navPills = document.querySelectorAll('.nav-pills [data-bs-toggle="pill"]')
            calcProgress(navPills.length, 0)

            navPills.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    calcProgress(navPills.length, Array.prototype.indexOf.call(navPills, event.target))
                })
            })

            function calcProgress(sampleCount, progressIndex) {
                if (!progressbar) return
                if (progressIndex === 0) return progressbar.style.width = 0 + '%'

                progressbar.style.width = (100 / (sampleCount - 1)) * progressIndex + '%'
            }
        </script>
    @endsection
</x-app-layout>
