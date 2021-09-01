<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create dog</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Create dog') }}
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

    @if ($errors->any())
        <div class="my-4">
            <x-alert-danger class="my-4">
                <strong>Look! You got {{ $errors->count() }} errors</strong>
            </x-alert-danger>
        </div>
    @endif

    {{-- CONTENT SECTION --}}
    <x-form-post action="{{ route('dogs.store') }}">
        <x-slot name="title">Course Syllabus</x-slot>

        <h5>Introduction</h5>
        <div class="row mb-3 g-3">
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

        <h5>Course Description</h5>
        <div class="row mb-3">
            <div class="col-12">
                <x-button class="btn-secondary mb-3" id="addfile-c-description-paragraph">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 30 30" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                        <div class="col-10 paragraph-input">
                            <x-input-textarea name="course_description[paragraphs][{{ $i }}]"
                                :error="'course_description.paragraphs.'. $i">
                            </x-input-textarea>

                            @error('course_description.paragraphs.' . $i)
                                <x-input-error :for="'course_description.paragraphs.'. $i"></x-input-error>
                            @enderror
                        </div>

                        @if ($i === 0)
                            <div class="col-2"></div>
                        @else
                            <div class="col-2">
                                <a href="#" class="btn btn-link remove-paragraph">remove</a>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <h5>Course Outcomes</h5>
        <div class="row mb-3">
            <div class="col-12">
                <x-button class="btn-secondary mb-3" id="addfile-c-outcomes-paragraph">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 30 30" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                        <div class="col-10 paragraph-input">
                            <x-input-textarea name="course_outcomes[paragraphs][{{ $i }}]"
                                :error="'course_outcomes.paragraphs.'. $i">
                            </x-input-textarea>

                            @error('course_outcomes.paragraphs.' . $i)
                                <x-input-error :for="'course_outcomes.paragraphs.'. $i"></x-input-error>
                            @enderror
                        </div>

                        @if ($i === 0)
                            <div class="col-2"></div>
                        @else
                            <div class="col-2">
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 30 30" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-plus-square">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <line x1="12" y1="8" x2="12" y2="16" />
                        <line x1="8" y1="12" x2="16" y2="12" />
                    </svg>

                    Add a list
                </x-button>

                <x-table id="sortable">
                    <x-slot name="thead">
                        <th> </th>
                        <th></th>
                    </x-slot>

                    @for ($i = 0; $i < $courseOutcomesLists; $i++)
                        <tr class="ui-state-default">
                            <td class="col-10">
                                <x-input name="course_outcomes[lists][{{ $i }}]"
                                    :error="'course_outcomes.lists.' . $i">
                                </x-input>

                                @error('course_outcomes.lists.' . $i)
                                    <x-input-error :for="'course_outcomes.lists.' . $i"></x-input-error>
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

            <x-slot name="actions">
                <x-button type="submit" class="btn-primary">Submit</x-button>
            </x-slot>
        </div>
    </x-form-post>

    @section('script')
        <script>
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
                inputGroupSelector: '#sortable tbody',
                inputGroupName: 'course_outcomes[lists]',
                inputErrorName: 'course_outcomes.lists',
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
                                <div class="col-10 paragraph-input">
                                    <x-input-textarea name="${inputGroupName}[${inputCount}]" error="${inputErrorName}.${inputCount}">
                                        </x-input-textarea>
                                </div>

                                <div class="col-2">
                                    <a href="#" class="btn btn-link remove-paragraph">remove</a>
                                </div>
                            </div>
                            `
                        )

                    } else if (type === 'list') {
                        $(inputGroupSelector).append(
                            `<tr class="ui-state-default">
                                <td class="col-10">
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

                    $('.remove-paragraph').click(function(e) {
                        e.preventDefault()
                        $(this).closest('.row').remove()
                    })
                    $('.remove-list').click(function(e) {
                        e.preventDefault()
                        $(this).closest('tr').remove()
                    })
                })
            }

            $('.remove-paragraph').click(function(e) {
                e.preventDefault()
                $(this).closest('.row').remove()
            })
            $('.remove-list').click(function(e) {
                e.preventDefault()
                $(this).closest('tr').remove()
            })
        </script>
    @endsection
</x-app-layout>
