<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resources.index') }}">Resources</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create syllabus</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Create syllabus') }}
            </small>

            {{-- HEADER ACTIONS SECTION --}}
            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
        <div class="my-4">
            <x-alert-success>
                {{ session()->get('success') }}

                <a href="{{ route('resources.index') }}">
                    <strong class="px-2">Go see the resources now?</strong>
                </a>
            </x-alert-success>
        </div>
    @endif

    <h6 class="mt-4 mb-0">
        <x-nav-tabs>
            <x-nav-link href="resources.create" id="home-tab" class="syllabus-tabs
            px-4 py-3">
                Regular
            </x-nav-link>

            <x-nav-link href="syllabi.create" id="profile-tab" class="syllabus-tabs
            px-4 py-3">
                Syllabus
            </x-nav-link>
        </x-nav-tabs>
    </h6>

    <div class="row">
        <div class="col-12">
            <x-card-body class="tab-content rounded-0 rounded-bottom border border-top-0 shadow-sm">
                @if ($errors->any())
                    <x-alert-danger class="my-4">
                        <span>Look! You got <strong>{{ $errors->count() }}</strong> errors</span>
                    </x-alert-danger>
                @endif

                <x-form-post action="{{ route('syllabi.store') }}" id="syllabusForm">
                    <x-slot name="title">
                        Course Syllabus Create Form
                    </x-slot>

                    <x-slot name="titleDescription">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste nam iusto aspernatur nemo
                        asperiores quam repellendus nesciunt ipsum qui culpa? Iure hic consequuntur asperiores eos
                        tempore voluptas cupiditate, dolore est.
                    </x-slot>

                    <div class="row mb-3">
                        <div class="col-12 col-lg-4">
                            <div class="py-4 position-sticky start-0 top-0">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <x-button class="tab-btn prev btn-success form-control py-2 disabled">
                                            Prev Chapter
                                        </x-button>
                                    </div>
                                    <div class="col-6">
                                        <x-button class="tab-btn next btn-success form-control py-2">
                                            Next Chapter
                                        </x-button>
                                    </div>
                                    <div class="col-12">
                                        <x-input-button class="btn-primary py-2" name="syllabus_preview" type="submit"
                                            value="Download preview">
                                        </x-input-button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content col-12 col-lg-8" id="syllabus-tab-content">
                            <div class="p-2 mt-5 mb-4">
                                <x-nav-progress id="createResourceTablist">
                                    <x-rounded-pill-button :class="'active'" :id="'pills-home-tab'"
                                        :target="'#pills-home'">
                                        1
                                    </x-rounded-pill-button>

                                    <x-rounded-pill-button :id="'pills-profile-tab'" :target="'#pills-profile'">
                                        2
                                    </x-rounded-pill-button>

                                    <x-rounded-pill-button :id="'pills-contact-tab'" :target="'#pills-contact'">
                                        3
                                    </x-rounded-pill-button>
                                </x-nav-progress>
                            </div>

                            <x-tab-pane :active="'true'" id="pills-home" aria-labelledby="pills-home-tab">
                                <x-slot name="title">Chapter 1 - Course Description</x-slot>

                                <div class="row mb-3 mt-4 g-3">
                                    <div class="col-12 col-lg-3">
                                        <x-label for="course_code" :value="'Course code'"></x-label>

                                        <x-input name="course_code">
                                        </x-input>

                                        @error('course_code')
                                            <x-input-error :for="'course_code'"></x-input-error>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <x-label for="course_title" :value="'Course title'"></x-label>

                                        <x-input name="course_title">
                                        </x-input>

                                        @error('course_title')
                                            <x-input-error :for="'course_title'"></x-input-error>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <x-label for="credit" :value="'Credit'"></x-label>

                                        <x-input name="credit">
                                        </x-input>

                                        @error('credit')
                                            <x-input-error :for="'credit'"></x-input-error>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <x-label for="time_allotment" :value="'Time allotment'"></x-label>

                                        <x-input name="time_allotment">
                                        </x-input>

                                        @error('time_allotment')
                                            <x-input-error :for="'time_allotment'"></x-input-error>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <x-label for="professor" :value="'Professor'"></x-label>

                                        <x-input name="professor">
                                        </x-input>

                                        @error('professor')
                                            <x-input-error :for="'professor'"></x-input-error>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 mt-4">
                                    <div class="col-12">
                                        <x-button class="btn-secondary mb-3" id="addfile-c-description-paragraph">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-square">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                                <line x1="12" y1="8" x2="12" y2="16" />
                                                <line x1="8" y1="12" x2="16" y2="12" />
                                            </svg>

                                            Add a paragraph
                                        </x-button>
                                    </div>

                                    <div class="col-12" id="c-description-paragraph">
                                        @for ($i = 0; $i < $courseDescriptionParagraphs; $i++)
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-1">{{ $i + 1 . '.' }}</div>

                                                <div class="col-12 col-lg-9 paragraph-input">
                                                    <x-input-textarea
                                                        name="course_description[paragraphs][{{ $i }}]"
                                                        :error="'course_description.paragraphs.'.$i">
                                                    </x-input-textarea>

                                                    @error('course_description.paragraphs.' . $i)
                                                        <x-input-error :for="'course_description.paragraphs.'.$i">
                                                        </x-input-error>
                                                    @enderror
                                                </div>

                                                @if ($i === 0)
                                                    <div class="col-12 col-lg-2"></div>
                                                @else
                                                    <div class="col-12 col-lg-2">
                                                        <a href="#" class="btn btn-link remove-paragraph">remove</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </x-tab-pane>

                            <x-tab-pane id="pills-profile" aria-labelledby="pills-profile-tab">
                                <x-slot name="title">Chapter 2 - Course Outcomes</x-slot>

                                <div class="row mb-3 mt-4">
                                    <div class="col-12">
                                        <x-button class="btn-secondary mb-3" id="addfile-c-outcomes-paragraph">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-square">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                                <line x1="12" y1="8" x2="12" y2="16" />
                                                <line x1="8" y1="12" x2="16" y2="12" />
                                            </svg>

                                            Add a paragraph
                                        </x-button>
                                    </div>

                                    <div class="col-12" id="c-outcomes-paragraph">
                                        @for ($i = 0; $i < $courseOutcomesParagraphs; $i++)
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-1">{{ $i + 1 }}.</div>

                                                <div class="col-12 col-lg-9 paragraph-input">
                                                    <x-input-textarea
                                                        name="course_outcomes[paragraphs][{{ $i }}]"
                                                        :error="'course_outcomes.paragraphs.'. $i">
                                                    </x-input-textarea>

                                                    @error('course_outcomes.paragraphs.' . $i)
                                                        <x-input-error :for="'course_outcomes.paragraphs.'. $i">
                                                        </x-input-error>
                                                    @enderror
                                                </div>

                                                @if ($i === 0)
                                                    <div class="col-12 col-lg-2"></div>
                                                @else
                                                    <div class="col-12 col-lg-2">
                                                        <a href="#" class="btn btn-link remove-paragraph">remove</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 my-3">
                                        <x-button class="btn-secondary" id="addfile-c-outcomes-list">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-square">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                                <line x1="12" y1="8" x2="12" y2="16" />
                                                <line x1="8" y1="12" x2="16" y2="12" />
                                            </svg>

                                            Add a list
                                        </x-button>

                                        <x-table id="c-outcomes-list">
                                            <x-slot name="thead">
                                                <th> </th>
                                                <th> </th>
                                                <th></th>
                                            </x-slot>

                                            @for ($i = 0; $i < $courseOutcomesLists; $i++)
                                                <tr class="ui-state-default">
                                                    <td class="col-1">{{ $i + 1 }}.</td>

                                                    <td class="col-9">
                                                        <x-input name="course_outcomes[lists][{{ $i }}]"
                                                            :error="'course_outcomes.lists.' . $i">
                                                        </x-input>

                                                        @error('course_outcomes.lists.' . $i)
                                                            <x-input-error :for="'course_outcomes.lists.' . $i">
                                                            </x-input-error>
                                                        @enderror
                                                    </td>

                                                    @if ($i === 0)
                                                        <td class="col-2"></td>
                                                    @else
                                                        <td class="col-2">
                                                            <a href="#" class="btn btn-link remove-list">remove</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endfor
                                        </x-table>
                                    </div>
                                </div>
                            </x-tab-pane>

                            <x-tab-pane id="pills-contact" aria-labelledby="pills-contact-tab">
                                <x-slot name="title">Chapter 3 - Learning Outcomes</x-slot>

                                <div class="row mb-3 mt-4">
                                    <div class="col-12">
                                        <x-button class="btn-secondary mb-3" id="addfile-l-outcomes-paragraph">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-square">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                                <line x1="12" y1="8" x2="12" y2="16" />
                                                <line x1="8" y1="12" x2="16" y2="12" />
                                            </svg>

                                            Add a paragraph
                                        </x-button>
                                    </div>

                                    <div class="col-12" id="l-outcomes-paragraph">
                                        @for ($i = 0; $i < $learningOutcomesParagraphs; $i++)
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-1">{{ $i + 1 }}.</div>

                                                <div class="col-12 col-lg-9 paragraph-input">
                                                    <x-input-textarea
                                                        name="learning_outcomes[paragraphs][{{ $i }}]"
                                                        :error="'learning_outcomes.paragraphs.'. $i">
                                                    </x-input-textarea>

                                                    @error('learning_outcomes.paragraphs.' . $i)
                                                        <x-input-error :for="'learning_outcomes.paragraphs.'. $i">
                                                        </x-input-error>
                                                    @enderror
                                                </div>

                                                @if ($i === 0)
                                                    <div class="col-12 col-lg-2"></div>
                                                @else
                                                    <div class="col-12 col-lg-2">
                                                        <a href="#" class="btn btn-link remove-paragraph">remove</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 my-3">
                                        <x-button class="btn-secondary" id="addfile-l-outcomes-list">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-square">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                                <line x1="12" y1="8" x2="12" y2="16" />
                                                <line x1="8" y1="12" x2="16" y2="12" />
                                            </svg>

                                            Add a list
                                        </x-button>

                                        <x-table id="l-outcomes-list">
                                            <x-slot name="thead">
                                                <th></th>
                                                <th> </th>
                                                <th></th>
                                            </x-slot>

                                            @for ($i = 0; $i < $learningOutcomesLists; $i++)
                                                <tr class="ui-state-default">
                                                    <td class="col-1">{{ $i + 1 }}.</td>

                                                    <td class="col-9">
                                                        <x-input name="learning_outcomes[lists][{{ $i }}]"
                                                            :error="'learning_outcomes.lists.' . $i">
                                                        </x-input>

                                                        @error('learning_outcomes.lists.' . $i)
                                                            <x-input-error :for="'learning_outcomes.lists.' . $i">
                                                            </x-input-error>
                                                        @enderror
                                                    </td>

                                                    @if ($i === 0)
                                                        <td class="col-2"></td>
                                                    @else
                                                        <td class="col-2">
                                                            <a href="#" class="btn btn-link remove-list">remove</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endfor
                                        </x-table>
                                    </div>
                                </div>
                            </x-tab-pane>
                        </div>
                    </div>

                    <x-slot name="actions">
                        <x-button type="submit" class="btn-primary">Save changes</x-button>

                        <div class="mt-3">
                            <x-input-check :name="'check_stay'" :label="'Check to stay after submit'" checked>
                            </x-input-check>
                        </div>
                    </x-slot>
                </x-form-post>
            </x-card-body>
        </div>
    </div>

    @section('script')
        <script>
            (function($) {
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

                $('#profile-tab, #home-tab').click(function(event) {
                    showLeaveConfirmationCheck(event);
                })

                function showLeaveConfirmationCheck(event) {
                    let required = $('form input ,form textarea, form select').filter(
                        ':not([type="checkbox"]):not([type="hidden"]):not([name="course_id"]):not([type="submit"])');
                    let allRequired = false;

                    required.each(function(index, value) {

                        if ($(value).val().length > 0) {
                            allRequired = true;
                        }
                    });

                    if (allRequired == true) {
                        let conf = confirm('Are you sure you want to leave this page without saving your changes?');

                        if (conf === false) {
                            event.preventDefault();
                        }
                    }
                }

                addParagraphOrList({
                    addButtonSelector: '#addfile-c-description-paragraph',
                    inputGroupSelector: '#c-description-paragraph',
                    inputGroupName: 'course_description[paragraphs]',
                    inputErrorName: 'course_description.paragraphs',
                    type: 'paragraph'
                })
                addParagraphOrList({
                    addButtonSelector: '#addfile-c-outcomes-paragraph',
                    inputGroupSelector: '#c-outcomes-paragraph',
                    inputGroupName: 'course_outcomes[paragraphs]',
                    inputErrorName: 'course_outcomes.paragraphs',
                    type: 'paragraph'
                })
                addParagraphOrList({
                    addButtonSelector: '#addfile-c-outcomes-list',
                    inputGroupSelector: '#c-outcomes-list tbody',
                    inputGroupName: 'course_outcomes[lists]',
                    inputErrorName: 'course_outcomes.lists',
                    type: 'list'
                })
                addParagraphOrList({
                    addButtonSelector: '#addfile-l-outcomes-paragraph',
                    inputGroupSelector: '#l-outcomes-paragraph',
                    inputGroupName: 'learning_outcomes[paragraphs]',
                    inputErrorName: 'learning_outcomes.paragraphs',
                    type: 'paragraph'
                })
                addParagraphOrList({
                    addButtonSelector: '#addfile-l-outcomes-list',
                    inputGroupSelector: '#l-outcomes-list tbody',
                    inputGroupName: 'learning_outcomes[lists]',
                    inputErrorName: 'learning_outcomes.lists',
                    type: 'list'
                })

                function addParagraphOrList({
                    addButtonSelector,
                    inputGroupSelector,
                    inputGroupName,
                    inputErrorName,
                    type
                }) {

                    $(addButtonSelector).click(function() {
                        let inputCount = $(inputGroupSelector).children().length

                        if (type === 'paragraph') {
                            $(inputGroupSelector).append(
                                `<div class="row mb-3">
                                <div class="col-12 col-lg-1">*</div>
                                <div class="col-12 col-lg-9 paragraph-input">
                                    <x-input-textarea name="${inputGroupName}[${inputCount}]" error="${inputErrorName}.${inputCount}">
                                        </x-input-textarea>
                                </div>

                                <div class="col-12 col-lg-2">
                                    <a href="#" class="btn btn-link remove-paragraph">remove</a>
                                </div>
                            </div>
                            `
                            )

                        } else if (type === 'list') {
                            $(inputGroupSelector).append(
                                `<tr class="ui-state-default">
                                <td class="col-1">*</td>
                                <td class="col-9">
                                    <x-input name="${inputGroupName}[${inputCount}]" error="${inputErrorName}.${inputCount}">
                                    </x-input>
                                </td>

                                <td class="col-2">
                                    <a href="#" class="btn btn-link remove-list">remove</a>
                                </td>
                            </tr>
                            `
                            )
                        }

                        removeInputGroup();
                    })
                }

                removeInputGroup();

                function removeInputGroup() {
                    $('.remove-paragraph').click(function(e) {
                        e.preventDefault()
                        $(this).closest('.row').remove()
                    })
                    $('.remove-list').click(function(e) {
                        e.preventDefault()
                        $(this).closest('tr').remove()
                    })
                }

                $('.tab-btn.next').click(function() {
                    $('#syllabus-tab-content [data-bs-toggle="pill"].active').parent().next().children().tab(
                        'show')
                })
                $('.tab-btn.prev').click(function() {
                    $('#syllabus-tab-content [data-bs-toggle="pill"].active').parent().prev().children().tab(
                        'show')
                })

                setNavPill();

                function setNavPill() {
                    $('[data-bs-toggle="pill"]').on('shown.bs.tab', function(event) {
                        let defaultFirstTabItem = $('#syllabus-tab-content .nav-pills')
                            .children(':first-child')[0]
                        let defaultLastTabItem = $('#syllabus-tab-content .nav-pills')
                            .children(':last-child')[0]
                        let currentTabLink = $(event.target)
                        let currentTabItem = currentTabLink.parent()[0]

                        if (currentTabItem == defaultFirstTabItem) {
                            $('.prev').addClass('disabled')
                            $('.next').removeClass('disabled')
                        } else if (currentTabItem == defaultLastTabItem) {
                            $('.prev').removeClass('disabled')
                            $('.next').addClass('disabled')
                        } else {
                            $('.tab-btn').removeClass('disabled')
                        }
                    })
                }
            })(jQuery);
        </script>
    @endsection
</x-app-layout>
