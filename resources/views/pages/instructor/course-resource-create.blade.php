<x-app-layout>
    <x-slot name="header">
        New resource
    </x-slot>

    <x-slot name="headerTitle">
        Page action
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold"
                href="{{ route('instructor.course.show', $lesson->course->id) }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('instructor.course.show', $lesson->course->id) }}">{{ $lesson->course->code }}</a>
        </li>

        <li class="breadcrumb-item " aria-current="page">{{ $lesson->title }}</li>
        <li class="breadcrumb-item active" aria-current="page">New resource</li>
    </x-slot>

    <div class="row g-4">
        @if ($errors->any())
            <div class="col-12">
                <div class="alert alert-danger my-0">
                    <ul class="nav flex-column">
                        @foreach ($errors->all() as $error)
                            <li class="nav-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if (session()->exists('message'))
            <div class="col-12">
                <div class="alert alert-success my-0">
                    <span>{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <div class="col-4">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">
                            Select Submit Type
                        </x-slot>
                        <x-slot name="body">
                            <ul class="w-100 nav nav-pills list-group gap-2" id="pills-tab" role="tablist">
                                <li class="nav-item rounded overflow-hidden">
                                    <a href="#"
                                        class="submit-resource-tab list-group-item list-group-item-action d-flex gap-3 py-3 active"
                                        aria-current="true" id="resource-modal-tabcontent-submit-general-tab"
                                        data-bs-toggle="pill" data-bs-target="#resource-modal-tabcontent-submit-general"
                                        data-label="general">
                                        <span class="material-icons">
                                            room_preferences
                                        </span>
                                        <div class="d-flex gap-2 w-100 justify-content-between">
                                            <div>
                                                <h6 class="mb-0">General</h6>
                                                <p class="mb-0 opacity-75">No specific checking method</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item rounded overflow-hidden">
                                    <a href="#"
                                        class="submit-resource-tab list-group-item list-group-item-action d-flex gap-3 py-3"
                                        aria-current="true" id="resource-modal-tabcontent-submit-syllabus-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#resource-modal-tabcontent-submit-syllabus"
                                        data-label="syllabus">
                                        <span class="material-icons">
                                            history_edu
                                        </span>

                                        <div class="d-flex gap-2 w-100 justify-content-between">
                                            <div>
                                                <h6 class="mb-0">Syllabus</h6>
                                                <p class="mb-0 opacity-75">Checks the use of verbs in both course and
                                                    learning outcomes</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item rounded overflow-hidden">
                                    <a href="#"
                                        class="submit-resource-tab list-group-item list-group-item-action d-flex gap-3 py-3"
                                        aria-current="true" id="resource-modal-tabcontent-submit-presentation-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#resource-modal-tabcontent-submit-presentation"
                                        data-label="presentation">
                                        <span class="material-icons">
                                            present_to_all
                                        </span>

                                        <div class="d-flex gap-2 w-100 justify-content-between">
                                            <div>
                                                <h6 class="mb-0">Presentation</h6>
                                                <p class="mb-0 opacity-75">Checks the existence of source reference page
                                                    and
                                                    source links</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </x-slot>
                    </x-real.card>
                </div>

                <div class="col-12">
                    <x-real.card :variant="'secondary'">
                        <x-slot name="header">
                            Recent Submissions
                        </x-slot>

                        <x-slot name="body">
                            <ul class="submit-resource-log submit-resource-logs-list submitResourceLogsList w-100 list-group mt-3"
                                id="submit-general-log">
                                @forelse ($lesson->course->resources()->orderByDesc('created_at')->limit(5)->get() as $resource)
                                    <li class="list-group-item">{{ $resource->created_at }}</li>
                                @empty
                                    <x-real.no-rows :variant="'light'">
                                        <x-slot name="label">No submitted resources yet</x-slot>
                                    </x-real.no-rows>
                                @endforelse
                            </ul>

                            <small class="d-block text-end mt-3">
                                <a href="#">Show more >></a>
                            </small>
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>

        <div class="col-8">
            {{-- TAB CONTENT --}}
            <div class="tab-content" id="pills-tabContent">
                <!-- SUBMIT GENERAL RESOURCE TAB -->
                <div class="submit-resource-tabpane tab-pane fade show active"
                    id="resource-modal-tabcontent-submit-general" role="tabpanel"
                    aria-labelledby="resource-modal-tabcontent-submit-general-tab">

                    <x-real.card :variant="'secondary'">
                        <x-slot name="header">
                            General Upload
                        </x-slot>

                        <x-slot name="action">
                            <ul class="nav nav-pills justify-content-end gap-3" id="pills-tab" role="tablist">
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0 active" id="pills-profile-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab">New
                                        file(s)</button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="storageUploadStandaloneBtn nav-link py-0 text-dark rounded-0"
                                        id="fileupload-standalone" data-bs-toggle="pill" data-bs-target="#pills-profile"
                                        type="button" role="tab">
                                        Storage
                                    </button>
                                </li>
                            </ul>
                        </x-slot>

                        <x-slot name="body">
                            <div class="dropzone">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                                        <x-form-post action="{{ route('resources.store') }}"
                                            class="submit-resource-form" id="resourceForm">
                                            <x-input type="hidden" name="course_id" value="{{ $lesson->course->id }}">
                                            </x-input>
                                            <x-input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                                            </x-input>
                                            <div id="fileMaster">
                                                <div class="row-group align-items-start" id="file-g">
                                                    <div class="submit-resource-form-actions row g-0" id="actions">
                                                        <div class="col-12">
                                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                                            <div class="d-flex align-items-start">
                                                                <div class="w-100 text-center">
                                                                    <x-button
                                                                        :class="'border-primary hstack gap-3 active btn-light fileinput-button dz-clickable w-100'"
                                                                        style="height: 140px; border-style: dashed !important;">
                                                                        <span
                                                                            class="material-icons align-middle md-48 text-primary">
                                                                            file_upload
                                                                        </span>

                                                                        <div
                                                                            class="d-flex flex-column align-items-start gap-1">
                                                                            <span>Drop files here or click to
                                                                                upload</span>

                                                                            <small class="text-primary">Upload up to
                                                                                10
                                                                                files at a time</small>
                                                                        </div>
                                                                    </x-button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-4 col-lg-5 d-flex gap-3">
                                                            <x-button type="submit" :class="'w-100 btn-primary d-none'"
                                                                id="submit-resource">
                                                                <span>Submit</span>
                                                            </x-button>

                                                            <x-button :class="'w-100 btn-danger cancel d-none'">
                                                                <span>Cancel upload</span>
                                                            </x-button>
                                                        </div>

                                                        <div class="col-12">
                                                            <!-- The global file processing state -->
                                                            <span class="fileupload-process w-100">
                                                                <div id="total-progress" class="progress active w-100"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    aria-valuenow="0">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                        role="progressbar" style="width: 0%;"
                                                                        data-dz-uploadprogress="">
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </div>

                                                        <div class="col-12 mt-3">
                                                            <div class="alert alert-success fade" role="alert">
                                                                <strong class="submit-resource-alert"
                                                                    id="submit-resource-alert"></strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="file-upload-container table-responsive overflow-auto"
                                                        id="file-upload-container">
                                                        <div class="">
                                                            <h6 class="border-bottom pb-2 mb-3">Uploaded files</h6>

                                                            <div class="d-none">
                                                                <div id="template"
                                                                    class="list-group gap-3 dropzone-template file-row">
                                                                    <!-- This is used as the file preview template -->
                                                                    <div
                                                                        class="list-group-item border-0 d-flex align-items-start gap-3 text-muted pt-3">
                                                                        <div class="preview bg-light">
                                                                            <img style="width: 110px; height: 110px"
                                                                                data-dz-thumbnail />
                                                                        </div>
                                                                        <div
                                                                            class="hstack align-items-start gap-3 pb-3 mb-0 small lh-sm border-bottom w-100">
                                                                            <div class="overflow-hidden "
                                                                                style="width: 180px">
                                                                                <p class="name text-wrap" data-dz-name>
                                                                                </p>
                                                                                <p class="size" data-dz-size>
                                                                                </p>
                                                                                <strong class="error text-danger"
                                                                                    data-dz-errormessage></strong>
                                                                                <span class="badge bg-success">Uploaded
                                                                                    successfully</span>
                                                                            </div>
                                                                            <div class="file-metadata">
                                                                                <div class="row g-2">
                                                                                    <x-input name="file[]"
                                                                                        class="file" hidden>
                                                                                    </x-input>

                                                                                    <div
                                                                                        class="file-group d-none col-12">
                                                                                        <div class="form-floating mb-3">
                                                                                            <x-input name="title[]"
                                                                                                placeholder="_">
                                                                                            </x-input>
                                                                                            <x-label>Name
                                                                                            </x-label>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div
                                                                                        class="file-group d-none col-12">
                                                                                        <div class="form-floating mb-3">
                                                                                            <x-input-textarea
                                                                                                name="description[]"
                                                                                                placeholder="_">
                                                                                            </x-input-textarea>
                                                                                            <x-label>Description
                                                                                            </x-label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-grid gap-2">
                                                                                <div class="progress progress-striped active"
                                                                                    role="progressbar" aria-valuemin="0"
                                                                                    aria-valuemax="100"
                                                                                    aria-valuenow="0">
                                                                                    <div class="progress-bar progress-bar-success"
                                                                                        style="width:0%;"
                                                                                        data-dz-uploadprogress>
                                                                                    </div>
                                                                                </div>

                                                                                <x-button
                                                                                    :class="'btn-light text-primary start'">
                                                                                    <span>Start</span>
                                                                                </x-button>

                                                                                <x-button data-dz-remove
                                                                                    :class="'btn-light text-primary cancel'">
                                                                                    <span
                                                                                        class="material-icons md-18 align-middle">
                                                                                        block
                                                                                    </span>

                                                                                    Cancel
                                                                                </x-button>

                                                                                <x-button data-dz-remove
                                                                                    :class="'btn-light text-primary delete'">
                                                                                    <span
                                                                                        class="material-icons md-18 align-middle">
                                                                                        close
                                                                                    </span>

                                                                                    Remove
                                                                                </x-button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="dropzone-preview previews" id="previews"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </x-form-post>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                                        <x-form-post action="{{ route('resources.storeByUrl') }}" id="storeByUrlForm"
                                            class="storeByUrlForm">
                                            <div class="row">
                                                <x-input hidden type="url" name="fileUrl" id="fileUrlInput"
                                                    class="alexusmaiFileUrlInput"></x-input>

                                                <div class="col-12 mt-3">
                                                    <label class="form-text">Filename</label>
                                                    <span class="alexusmaiFileText h5 text-secondary fw-bold"
                                                        id="fileText">
                                                    </span>
                                                    <a href="javascript:void(0)" class="openStorageBtn btn btn-link"
                                                        id="openStorageBtn">Open storage</a>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <x-label>Title</x-label>
                                                    <x-input name="title"></x-input>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <x-label>Description</x-label>
                                                    <x-input-textarea name="description">
                                                    </x-input-textarea>
                                                </div>

                                                <div class="col-12 my-5">
                                                    <button class="btn btn-success" type="submit">Submit</button>
                                                </div>

                                                <div class="col-12">
                                                    <div class="alert alert-danger fade">
                                                    </div>
                                                </div>
                                            </div>
                                        </x-form-post>
                                    </div>
                                </div>
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>

                <!-- SUBMIT SYLLABUS RESOURCE TAB -->
                <div class="submit-resource-tabpane tab-pane fade" id="resource-modal-tabcontent-submit-syllabus"
                    role="tabpanel" aria-labelledby="resource-modal-tabcontent-submit-syllabus-tab">
                    <x-real.card :variant="'secondary'">
                        <x-slot name="header">
                            Syllabus Upload
                        </x-slot>

                        <x-slot name="action">
                            <ul class="nav nav-pills justify-content-end gap-3" id="syllabusSubmitTab" role="tablist">
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0 active" id="syllabusSubmitFormTab"
                                        data-bs-toggle="pill" data-bs-target="#syllabusSubmitFormTabpane" type="button"
                                        role="tab">New
                                        file(s)</button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="storageUploadStandaloneBtn nav-link py-0 text-dark rounded-0"
                                        id="syllabusSubmitUrlTab" data-bs-toggle="pill"
                                        data-bs-target="#syllabusSubmitUrlTabpane" type="button" role="tab">
                                        Storage
                                    </button>
                                </li>
                            </ul>
                        </x-slot>

                        <x-slot name="body">
                            <div class="dropzone">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="syllabusSubmitFormTabpane"
                                        role="tabpanel">
                                        <x-form-post action="{{ route('syllabi.upload') }}"
                                            class="submit-resource-form" id="syllabusForm">
                                            <x-input type="hidden" name="course_id"
                                                value="{{ $lesson->course->id }}">
                                            </x-input>
                                            <x-input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                                            </x-input>
                                            <div id="fileMaster">
                                                <div class="row-group align-items-start" id="file-g">
                                                    <div class="submit-resource-form-actions row g-0" id="actions">
                                                        <div class="col-12">
                                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                                            <div class="d-flex align-items-start">
                                                                <div class="w-100 text-center">
                                                                    <x-button
                                                                        :class="'border-primary hstack gap-3 active btn-light fileinput-button dz-clickable w-100'"
                                                                        style="height: 140px; border-style: dashed !important;">
                                                                        <span
                                                                            class="material-icons align-middle md-48 text-primary">
                                                                            file_upload
                                                                        </span>

                                                                        <div
                                                                            class="d-flex flex-column align-items-start gap-1">
                                                                            <span>Drop files here or click to
                                                                                upload</span>

                                                                            <small class="text-primary">Upload 1 file
                                                                                at
                                                                                a time</small>
                                                                        </div>
                                                                    </x-button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-4 col-lg-5 d-flex gap-3">
                                                            <x-button type="submit" :class="'w-100 btn-primary d-none'"
                                                                id="submit-resource">
                                                                <span>Submit</span>
                                                            </x-button>

                                                            <x-button :class="'w-100 btn-danger cancel d-none'">
                                                                <span>Cancel upload</span>
                                                            </x-button>
                                                        </div>

                                                        <div class="col-12">
                                                            <!-- The global file processing state -->
                                                            <span class="fileupload-process w-100">
                                                                <div id="total-progress" class="progress active w-100"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    aria-valuenow="0">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                        role="progressbar" style="width: 0%;"
                                                                        data-dz-uploadprogress="">
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </div>

                                                        <div class="col-12 mt-3">
                                                            <div class="alert alert-success fade" role="alert">
                                                                <strong class="submit-resource-alert"
                                                                    id="submit-resource-alert"></strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="file-upload-container table-responsive overflow-auto"
                                                        id="file-upload-container">
                                                        <div class="">
                                                            <h6 class="border-bottom pb-2 mb-3">Uploaded files</h6>

                                                            <div class="d-none">
                                                                <div id="template"
                                                                    class="list-group gap-3 dropzone-template file-row">
                                                                    <!-- This is used as the file preview template -->
                                                                    <div
                                                                        class="list-group-item border-0 d-flex align-items-start gap-3 text-muted pt-3">
                                                                        <div class="preview bg-light">
                                                                            <img style="width: 110px; height: 110px"
                                                                                data-dz-thumbnail />
                                                                        </div>
                                                                        <div
                                                                            class="hstack align-items-start gap-3 pb-3 mb-0 small lh-sm border-bottom w-100">
                                                                            <div class="overflow-hidden "
                                                                                style="width: 180px">
                                                                                <p class="name text-wrap" data-dz-name>
                                                                                </p>
                                                                                <p class="size" data-dz-size>
                                                                                </p>
                                                                                <strong class="error text-danger"
                                                                                    data-dz-errormessage></strong>
                                                                                <span class="badge bg-success">Uploaded
                                                                                    successfully</span>
                                                                            </div>
                                                                            <div class="file-metadata">
                                                                                <div class="row g-2">
                                                                                    <x-input name="file[]"
                                                                                        class="file" hidden>
                                                                                    </x-input>

                                                                                    <div
                                                                                        class="file-group d-none col-12">
                                                                                        <div
                                                                                            class="form-floating mb-3">
                                                                                            <x-input name="title[]"
                                                                                                placeholder="_">
                                                                                            </x-input>
                                                                                            <x-label>Name
                                                                                            </x-label>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div
                                                                                        class="file-group d-none col-12">
                                                                                        <div
                                                                                            class="form-floating mb-3">
                                                                                            <x-input-textarea
                                                                                                name="description[]"
                                                                                                placeholder="_">
                                                                                            </x-input-textarea>
                                                                                            <x-label>Description
                                                                                            </x-label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-grid gap-2">
                                                                                <div class="progress progress-striped active"
                                                                                    role="progressbar" aria-valuemin="0"
                                                                                    aria-valuemax="100"
                                                                                    aria-valuenow="0">
                                                                                    <div class="progress-bar progress-bar-success"
                                                                                        style="width:0%;"
                                                                                        data-dz-uploadprogress>
                                                                                    </div>
                                                                                </div>

                                                                                <x-button
                                                                                    :class="'btn-light text-primary start'">
                                                                                    <span>Start</span>
                                                                                </x-button>

                                                                                <x-button data-dz-remove
                                                                                    :class="'btn-light text-primary cancel'">
                                                                                    <span
                                                                                        class="material-icons md-18 align-middle">
                                                                                        block
                                                                                    </span>

                                                                                    Cancel
                                                                                </x-button>

                                                                                <x-button data-dz-remove
                                                                                    :class="'btn-light text-primary delete'">
                                                                                    <span
                                                                                        class="material-icons md-18 align-middle">
                                                                                        close
                                                                                    </span>

                                                                                    Remove
                                                                                </x-button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="dropzone-preview previews" id="previews"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </x-form-post>
                                    </div>
                                    <div class="tab-pane fade" id="syllabusSubmitUrlTabpane" role="tabpanel">
                                        <x-form-post action="{{ route('syllabi.storeByUrl') }}" id="storeByUrlForm"
                                            class="storeByUrlForm">
                                            <div class="row">
                                                <x-input hidden type="url" name="fileUrl" id="fileUrlInput"
                                                    class="alexusmaiFileUrlInput"></x-input>

                                                <div class="col-12 mt-3">
                                                    <label class="form-text">Filename</label>
                                                    <span class="alexusmaiFileText h5 text-secondary fw-bold"
                                                        id="fileText">
                                                    </span>
                                                    <a href="javascript:void(0)" class="openStorageBtn btn btn-link"
                                                        id="openStorageBtn">Open storage</a>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <x-label>Title</x-label>
                                                    <x-input name="title"></x-input>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <x-label>Description</x-label>
                                                    <x-input-textarea name="description">
                                                    </x-input-textarea>
                                                </div>

                                                <div class="col-12 my-5">
                                                    <button class="btn btn-success" type="submit">Submit</button>
                                                </div>

                                                <div class="col-12">
                                                    <div class="alert alert-danger fade">
                                                    </div>
                                                </div>
                                            </div>
                                        </x-form-post>
                                    </div>
                                </div>
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>

                <!-- SUBMIT PRESENTATION RESOURCE TAB -->
                <div class="submit-resource-tabpane tab-pane fade" id="resource-modal-tabcontent-submit-presentation"
                    role="tabpanel" aria-labelledby="resource-modal-tabcontent-submit-presentation-tab">

                    <x-real.card :variant="'secondary'">
                        <x-slot name="header">
                            Presentation Upload
                        </x-slot>

                        <x-slot name="action">
                            <ul class="nav nav-pills justify-content-end gap-3" id="presentationSubmitTab"
                                role="tablist">
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0 active"
                                        id="presentationSubmitFormTab" data-bs-toggle="pill"
                                        data-bs-target="#presentationSubmitFormTabpane" type="button" role="tab">New
                                        file(s)</button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="storageUploadStandaloneBtn nav-link py-0 text-dark rounded-0"
                                        id="presentationSubmitUrlTab" data-bs-toggle="pill"
                                        data-bs-target="#presentationSubmitUrlTabpane" type="button" role="tab">
                                        Storage
                                    </button>
                                </li>
                            </ul>
                        </x-slot>

                        <x-slot name="body">
                            <div class="dropzone">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="presentationSubmitFormTabpane"
                                        role="tabpanel">
                                        <x-form-post action="{{ route('presentations.upload') }}"
                                            class="submit-resource-form" id="presentationForm">
                                            <x-input type="hidden" name="course_id"
                                                value="{{ $lesson->course->id }}">
                                            </x-input>
                                            <x-input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                                            </x-input>
                                            <div id="fileMaster">
                                                <div class="row-group align-items-start" id="file-g">
                                                    <div class="submit-resource-form-actions row g-0" id="actions">
                                                        <div class="col-12">
                                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                                            <div class="d-flex align-items-start">
                                                                <div class="w-100 text-center">
                                                                    <x-button
                                                                        :class="'border-primary hstack gap-3 active btn-light fileinput-button dz-clickable w-100'"
                                                                        style="height: 140px; border-style: dashed !important;">
                                                                        <span
                                                                            class="material-icons align-middle md-48 text-primary">
                                                                            file_upload
                                                                        </span>

                                                                        <div
                                                                            class="d-flex flex-column align-items-start gap-1">
                                                                            <span>Drop files here or click to
                                                                                upload</span>

                                                                            <small class="text-primary">Upload 1 file
                                                                                at
                                                                                a time</small>
                                                                        </div>
                                                                    </x-button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-4 col-lg-5 d-flex gap-3">
                                                            <x-button type="submit" :class="'w-100 btn-primary d-none'"
                                                                id="submit-resource">
                                                                <span>Submit</span>
                                                            </x-button>

                                                            <x-button :class="'w-100 btn-danger cancel d-none'">
                                                                <span>Cancel upload</span>
                                                            </x-button>
                                                        </div>

                                                        <div class="col-12">
                                                            <!-- The global file processing state -->
                                                            <span class="fileupload-process w-100">
                                                                <div id="total-progress" class="progress active w-100"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    aria-valuenow="0">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                        role="progressbar" style="width: 0%;"
                                                                        data-dz-uploadprogress="">
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </div>

                                                        <div class="col-12 mt-3">
                                                            <div class="alert alert-success fade" role="alert">
                                                                <strong class="submit-resource-alert"
                                                                    id="submit-resource-alert"></strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="file-upload-container table-responsive overflow-auto"
                                                        id="file-upload-container">
                                                        <div class="">
                                                            <h6 class="border-bottom pb-2 mb-3">Uploaded files</h6>

                                                            <div class="d-none">
                                                                <div id="template"
                                                                    class="list-group gap-3 dropzone-template file-row">
                                                                    <!-- This is used as the file preview template -->
                                                                    <div
                                                                        class="list-group-item border-0 d-flex align-items-start gap-3 text-muted pt-3">
                                                                        <div class="preview bg-light">
                                                                            <img style="width: 110px; height: 110px"
                                                                                data-dz-thumbnail />
                                                                        </div>
                                                                        <div
                                                                            class="hstack align-items-start gap-3 pb-3 mb-0 small lh-sm border-bottom w-100">
                                                                            <div class="overflow-hidden "
                                                                                style="width: 180px">
                                                                                <p class="name text-wrap" data-dz-name>
                                                                                </p>
                                                                                <p class="size" data-dz-size>
                                                                                </p>
                                                                                <strong class="error text-danger"
                                                                                    data-dz-errormessage></strong>
                                                                                <span class="badge bg-success">Uploaded
                                                                                    successfully</span>
                                                                            </div>
                                                                            <div class="file-metadata">
                                                                                <div class="row g-2">
                                                                                    <x-input name="file[]"
                                                                                        class="file" hidden>
                                                                                    </x-input>

                                                                                    <div
                                                                                        class="file-group d-none col-12">
                                                                                        <div
                                                                                            class="form-floating mb-3">
                                                                                            <x-input name="title[]"
                                                                                                placeholder="_">
                                                                                            </x-input>
                                                                                            <x-label>Name
                                                                                            </x-label>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div
                                                                                        class="file-group d-none col-12">
                                                                                        <div
                                                                                            class="form-floating mb-3">
                                                                                            <x-input-textarea
                                                                                                name="description[]"
                                                                                                placeholder="_">
                                                                                            </x-input-textarea>
                                                                                            <x-label>Description
                                                                                            </x-label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-grid gap-2">
                                                                                <div class="progress progress-striped active"
                                                                                    role="progressbar" aria-valuemin="0"
                                                                                    aria-valuemax="100"
                                                                                    aria-valuenow="0">
                                                                                    <div class="progress-bar progress-bar-success"
                                                                                        style="width:0%;"
                                                                                        data-dz-uploadprogress>
                                                                                    </div>
                                                                                </div>

                                                                                <x-button
                                                                                    :class="'btn-light text-primary start'">
                                                                                    <span>Start</span>
                                                                                </x-button>

                                                                                <x-button data-dz-remove
                                                                                    :class="'btn-light text-primary cancel'">
                                                                                    <span
                                                                                        class="material-icons md-18 align-middle">
                                                                                        block
                                                                                    </span>

                                                                                    Cancel
                                                                                </x-button>

                                                                                <x-button data-dz-remove
                                                                                    :class="'btn-light text-primary delete'">
                                                                                    <span
                                                                                        class="material-icons md-18 align-middle">
                                                                                        close
                                                                                    </span>

                                                                                    Remove
                                                                                </x-button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="dropzone-preview previews" id="previews"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </x-form-post>
                                    </div>
                                    <div class="tab-pane fade" id="presentationSubmitUrlTabpane" role="tabpanel">
                                        <x-form-post action="{{ route('presentations.uploadByUrl') }}"
                                            id="storeByUrlForm" class="storeByUrlForm">
                                            <div class="row">
                                                <x-input hidden type="url" name="fileUrl" id="fileUrlInput"
                                                    class="alexusmaiFileUrlInput"></x-input>

                                                <div class="col-12 mt-3">
                                                    <label class="form-text">Filename</label>
                                                    <span class="alexusmaiFileText h5 text-secondary fw-bold"
                                                        id="fileText">
                                                    </span>
                                                    <a href="javascript:void(0)" class="openStorageBtn btn btn-link"
                                                        id="openStorageBtn">Open storage</a>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <x-label>Title</x-label>
                                                    <x-input name="title"></x-input>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <x-label>Description</x-label>
                                                    <x-input-textarea name="description">
                                                    </x-input-textarea>
                                                </div>

                                                <div class="col-12 my-5">
                                                    <button class="btn btn-success" type="submit">Submit</button>
                                                </div>

                                                <div class="col-12">
                                                    <div class="alert alert-danger fade">
                                                    </div>
                                                </div>
                                            </div>
                                        </x-form-post>
                                    </div>
                                </div>
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>
    </div>


    @section('script')
        <script>
            $(document).ready(function() {
                /* ON SHOW SUBMIT TABS */
                $('.submit-resource-tab').each(function(index, tab) {
                    const $targetTabpaneId = $(tab).attr('data-bs-target')
                    const $targetTabpaneLabel = $(tab).attr('data-label')

                    const $dropzone = $($targetTabpaneId)

                    if ($dropzone[0].dropzone) return

                    let $previewNode = $dropzone.find(".dropzone-template");
                    let previewTemplate = $previewNode.parent().html();
                    $previewNode.parent().remove('.dropzone-template')

                    let dropzoneParams = {
                        url: "{{ route('upload-temporary-file.store') }}", // Set the url
                        params: {
                            _token: "{{ csrf_token() }}"
                        },
                        thumbnailWidth: 120,
                        thumbnailHeight: 120,
                        parallelUploads: 20,
                        previewTemplate: previewTemplate,
                        autoQueue: true, // Make sure the files aren't queued until manually added
                        previewsContainer: `${$targetTabpaneId} .dropzone-preview`, // Define the container to display the previews
                        clickable: `${$targetTabpaneId} .fileinput-button`, // Define the element that should be used as click trigger to select files.
                        maxFilesize: 5000
                    }

                    if ($targetTabpaneLabel === 'general') {
                        dropzoneParams['maxFiles'] = 5,
                            dropzoneParams['accept'] = function(file, done) {
                                if (
                                    file.type
                                ) {
                                    done();
                                } else {
                                    done("Error! Valid files should have a file extension.");
                                }
                            }
                    } else if ($targetTabpaneLabel === 'syllabus') {
                        dropzoneParams['maxFiles'] = 1
                        dropzoneParams['accept'] = function(file, done) {
                            if (
                                file.type ==
                                "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||
                                file.type == "application/msword"
                            ) {
                                done();
                            } else {
                                done("Error! You have to submit a docx or doc file.");
                            }
                        }
                    } else if ($targetTabpaneLabel === 'presentation') {
                        dropzoneParams['maxFiles'] = 1
                        dropzoneParams['accept'] = function(file, done) {
                            if (
                                file.type ==
                                "application/vnd.ms-powerpoint" ||
                                file.type ==
                                "application/vnd.openxmlformats-officedocument.presentationml.presentation"
                            ) {
                                done();
                            } else {
                                done("Error! You have to submit a pptx or ppt file.");
                            }
                        }
                    }

                    // Make the target tabpane a dropzone
                    let DropzoneInstance = new Dropzone($dropzone[0], dropzoneParams);

                    DropzoneInstance.on("addedfile", function(file) {
                        $dropzone.find("#syllabus-iframe-container").html("");
                        $dropzone.find('.submit-resource-alert').parent('.alert').removeClass('show')
                    });

                    DropzoneInstance.on("removedfile", function(file) {
                        let $input = $dropzone.find(
                                '.dropzone-preview .dz-success .file-metadata input[name="title[]"]'),
                            $submitButton = $dropzone.find(
                                '.submit-resource-form button[type="submit"]');

                        $input.unbind('keyup');
                        let trigger = false;

                        if ($input.length <= 0) {
                            console.log($input.length)
                            trigger = true;
                        } else {
                            $input.each(function() {
                                if (!$(this).val()) {
                                    trigger = true;
                                }
                            });
                        }

                        trigger ? $submitButton.addClass('disabled') : $submitButton
                            .removeClass(
                                'disabled');

                        $dropzone.find('.dropzone-preview .file-metadata').delegate($input, 'keyup',
                            function(e) {
                                let trigger = false;

                                $input.each(function() {
                                    if (!$(this).val()) {
                                        trigger = true;
                                    }
                                });

                                trigger ? $submitButton.addClass('disabled') : $submitButton
                                    .removeClass(
                                        'disabled');
                            })

                        if (DropzoneInstance.files.length <= 0) {
                            $dropzone.find(".submit-resource-form-actions .cancel").addClass('d-none')
                            $submitButton.addClass('d-none')
                        }
                    })

                    // Update the total progress bar
                    DropzoneInstance.on("totaluploadprogress", function(progress) {
                        $dropzone.find('.progress .progress-bar').css('width', progress + '%');
                    });

                    DropzoneInstance.on("sending", function(file) {
                        // Show the total progress bar when upload starts
                        $dropzone.find('.progress').css('opacity', 1);
                        $dropzone.find('.progress .progress-bar').css('width', '0%');

                        // And disable the start button
                        $(file.previewElement).find('.start').attr('disabled', 'disabled')
                    });

                    DropzoneInstance.on("success", function(file) {
                        $(file.previewElement).find('.file').val(file.xhr.responseText)
                        $(file.previewElement).find('.file-group').removeClass('d-none')

                        let $input = $dropzone.find(
                                '.dropzone-preview .file-metadata input[name="title[]"]'),
                            $submitButton = $dropzone.find(
                                '.submit-resource-form button[type="submit"]');

                        $submitButton.addClass('disabled')

                        $dropzone.find('.dropzone-preview .file-metadata').delegate($input, 'keyup',
                            function(e) {
                                let trigger = false;

                                $input.each(function() {
                                    if (!$(this).val()) {
                                        trigger = true;
                                    }
                                });

                                trigger ? $submitButton.addClass('disabled') : $submitButton
                                    .removeClass(
                                        'disabled');
                            })

                        $dropzone.find(".submit-resource-form-actions .cancel").removeClass('d-none')
                        $submitButton.removeClass('d-none')
                    });

                    // Hide the total progress bar when nothing's uploading anymore
                    DropzoneInstance.on("queuecomplete", function(progress) {
                        $dropzone.find('.progress').css('opacity', 0);
                    });

                    /* ON REMOVE ALL FILES */
                    $(".submit-resource-form-actions .cancel").click(function() {
                        DropzoneInstance.removeAllFiles(true);
                    });
                })

                $('.submit-resource-tab').on('shown.bs.tab', function(event) {

                })
            })
        </script>
    @endsection
</x-app-layout>
