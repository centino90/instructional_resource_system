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

        <li class="breadcrumb-item " aria-current="page">{{$lesson->title}}</li>
        <li class="breadcrumb-item active" aria-current="page">New resource</li>
    </x-slot>

    <div class="row">
        <div class="col-4">
            <div class="row g-3">
                <div class="col-12">
                    <div class="p-3 bg-white rounded shadow-sm">
                        <header class="hstack align-items-center gap-3 pb-2 mb-4 border-bottom">
                            <h6 class="mb-0">Submit Types</h6>
                        </header>

                        <ul class="w-100 nav nav-pills list-group gap-2" id="pills-tab" role="tablist">
                            <li class="nav-item rounded overflow-hidden">
                                <a href="#"
                                    class="submit-resource-tab list-group-item list-group-item-action d-flex gap-3 py-3 active"
                                    aria-current="true" id="resource-modal-tabcontent-submit-general-tab"
                                    data-bs-toggle="pill" data-bs-target="#resource-modal-tabcontent-submit-general"
                                    data-label="general">
                                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32"
                                        class="rounded-circle flex-shrink-0">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0">General</h6>
                                            <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
                                        </div>
                                        <small class="opacity-50 text-nowrap">now</small>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item rounded overflow-hidden">
                                <a href="#"
                                    class="submit-resource-tab list-group-item list-group-item-action d-flex gap-3 py-3"
                                    aria-current="true" id="resource-modal-tabcontent-submit-syllabus-tab"
                                    data-bs-toggle="pill" data-bs-target="#resource-modal-tabcontent-submit-syllabus"
                                    data-label="syllabus">
                                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32"
                                        class="rounded-circle flex-shrink-0">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0">Syllabus</h6>
                                            <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
                                        </div>
                                        <small class="opacity-50 text-nowrap">now</small>
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
                                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32"
                                        class="rounded-circle flex-shrink-0">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0">Presentation</h6>
                                            <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
                                        </div>
                                        <small class="opacity-50 text-nowrap">now</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-white rounded shadow-sm">
                        <header class="hstack align-items-center gap-3 pb-2 mb-4 border-bottom">
                            <h6 class="mb-0">Recent Submissions</h6>
                        </header>

                        <ul class="list-group mt-3">
                            <li class="list-group-item">
                                <ul id="submit-general-log"
                                    class="submit-resource-log submit-resource-logs-list submitResourceLogsList w-100 list-group mt-3">
                                </ul>
                            </li>
                        </ul>
                    </div>
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
                    <div class="p-3 bg-white rounded shadow-sm">
                        <!-- NAV TABS -->
                        <header class="hstack align-items-center justify-content-between gap-3 mb-4 border-bottom">
                            <h6 class="mb-0 pb-2">Upload</h6>

                            <ul class="nav nav-pills justify-content-end gap-3" id="pills-tab" role="tablist">
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link p-0 text-dark rounded-0 active" id="pills-profile-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab">New
                                        file(s)</button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="storageUploadStandaloneBtn nav-link p-0 text-dark rounded-0"
                                        id="fileupload-standalone" data-bs-toggle="pill" data-bs-target="#pills-profile"
                                        type="button" role="tab">
                                        Storage
                                    </button>
                                </li>
                            </ul>
                        </header>

                        <!-- DROPZONE -->
                        <div class="dropzone">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                                    <x-form-post onsubmit="event.preventDefault()"
                                        action="{{ route('resources.store') }}" class="submit-resource-form"
                                        id="resourceForm">
                                        <x-input type="hidden" name="course_id"></x-input>
                                        <div id="fileMaster">
                                            <div class="row-group align-items-start" id="file-g">
                                                <div class="submit-resource-form-actions row g-0" id="actions">
                                                    <div class="col-12">
                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                        <div class="d-flex align-items-start">
                                                            <div class="w-100 text-center">
                                                                <x-button
                                                                    :class="'border btn-light fileinput-button dz-clickable w-100'"
                                                                    style="height: 140px">
                                                                    <span class="material-icons align-middle">
                                                                        file_upload
                                                                    </span>
                                                                    <span class="ms-2">CHOOSE OR DRAG THE
                                                                        FILE(s)</span>
                                                                </x-button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-4 col-12 d-flex gap-3 flex-wrap">
                                                        <button type="submit" id="submit-resource"
                                                            class="btn btn-success flex-shrink-0 d-none">
                                                            Submit
                                                        </button>

                                                        <x-button :class="'btn-danger cancel d-none'">
                                                            <span>Cancel upload</span>
                                                        </x-button>
                                                    </div>

                                                    <div class="col-12">
                                                        <!-- The global file processing state -->
                                                        <span class="fileupload-process w-100">
                                                            <div id="total-progress" class="progress active w-100"
                                                                aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
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
                                                    <div class="table table-striped">
                                                        <div class="d-none">
                                                            <div id="template" class="dropzone-template file-row">
                                                                <!-- This is used as the file preview template -->
                                                                <div>
                                                                    <span class="preview" style="width: 140px">
                                                                        <img class="w-100" data-dz-thumbnail />
                                                                    </span>
                                                                </div>
                                                                <div style="max-width: 240px">
                                                                    <p class="name" data-dz-name>
                                                                    </p>
                                                                    <strong class="error text-danger"
                                                                        data-dz-errormessage></strong>
                                                                </div>
                                                                <div class="file-metadata">
                                                                    <div class="row">
                                                                        <x-input name="file[]" class="file"
                                                                            hidden>
                                                                        </x-input>

                                                                        <div class="col-12 d-none file-group">
                                                                            <x-label>Resource
                                                                                title
                                                                            </x-label>
                                                                            <x-input name="title[]">
                                                                            </x-input>
                                                                        </div>

                                                                        <div class="col-12 d-none file-group">
                                                                            <x-label>Description
                                                                            </x-label>
                                                                            <x-input-textarea name="description[]">
                                                                            </x-input-textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <p class="size" data-dz-size>
                                                                    </p>
                                                                    <div class="progress progress-striped active"
                                                                        role="progressbar" aria-valuemin="0"
                                                                        aria-valuemax="100" aria-valuenow="0">
                                                                        <div class="progress-bar progress-bar-success"
                                                                            style="width:0%;" data-dz-uploadprogress>
                                                                        </div>
                                                                    </div>
                                                                    <span class="badge bg-success">Uploaded
                                                                        successfully</span>
                                                                </div>
                                                                <div class="d-flex justify-content-end ps-5">
                                                                    <x-button :class="'btn-primary start'">
                                                                        <span>Start</span>
                                                                    </x-button>

                                                                    <x-button data-dz-remove
                                                                        :class="'btn-warning cancel'">
                                                                        <span>Cancel</span>
                                                                    </x-button>

                                                                    <x-button data-dz-remove
                                                                        :class="'btn-danger delete'">
                                                                        <span>Delete</span>
                                                                    </x-button>
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
                                        class="storeByUrlForm" onsubmit="event.preventDefault()">
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
                    </div>
                </div>

                <!-- SUBMIT SYLLABUS RESOURCE TAB -->
                <div class="submit-resource-tabpane tab-pane fade" id="resource-modal-tabcontent-submit-syllabus"
                    role="tabpanel" aria-labelledby="resource-modal-tabcontent-submit-syllabus-tab">
                    <div class="pt-4 row">
                        <div class="col-12 col-lg-4">
                            <header class="fs-5 fw-bold">Submit Syllabus</header>

                            <ul class="shadow list-group mt-3">
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0 fw-bold" id="submit-syllabus-tab-status"></h6>
                                        <small class="text-muted">Status</small>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item d-flex flex-wrap justify-content-between bg-light text-success">
                                    <span> Recent submissions </span>
                                    <strong id="submit-syllabus-log-count"></strong>
                                    <ul id="submit-syllabus-log" class="submit-resource-log w-100 list-group mt-3">
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="col-12 col-lg-8">
                            <!-- HIDDEN NAV TABS -->
                            <ul class="nav nav-tabs" id="syllabusSubmitTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active resource-submit-form-tab" id="syllabusSubmitFormTab"
                                        data-bs-toggle="tab" data-bs-target="#syllabusSubmitForm" type="button"
                                        role="tab">Upload</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link resource-submit-preview-tab" id="syllabusSubmitPreviewTab"
                                        data-bs-toggle="tab" data-bs-target="#syllabusSubmitPreview" type="button"
                                        role="tab">Preview</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="syllabusSubmitTabcontent">
                                <div class="tab-pane fade show active" id="syllabusSubmitForm" role="tabpanel">
                                    <div class="card rounded-0 rounded-bottom border-top-0">
                                        <!-- NAV TABS -->
                                        <header class="card-header py-0">
                                            <ul class="nav nav-pills justify-content-end gap-3" id="pills-tab"
                                                role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link text-dark fw-bold rounded-0 active"
                                                        id="syllabus-upload-newfile-tab" data-bs-toggle="pill"
                                                        data-bs-target="#syllabus-upload-newfile" type="button"
                                                        role="tab">New file(s)</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                        class="storageUploadStandaloneBtn nav-link text-dark fw-bold rounded-0"
                                                        id="syllabus-upload-storage-tab" data-bs-toggle="pill"
                                                        data-bs-target="#syllabus-upload-storage" type="button"
                                                        role="tab">
                                                        Storage
                                                    </button>
                                                </li>
                                            </ul>
                                        </header>
                                        <!-- DROPZONE -->
                                        <div class="card-body dropzone">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="syllabus-upload-newfile"
                                                    role="tabpanel">
                                                    <x-form-post onsubmit="event.preventDefault()"
                                                        action="{{ route('syllabi.upload') }}"
                                                        class="submit-resource-form" id="syllabusForm">
                                                        <x-input type="hidden" name="course_id"></x-input>
                                                        <div id="fileMaster-syllabus">
                                                            <div class="row-group" id="file-g-syllabus">
                                                                <div class="submit-resource-form-actions"
                                                                    id="actions-syllabus" class="row g-0">
                                                                    <div class="col-12">
                                                                        <!-- The global file processing state -->
                                                                        <span class="fileupload-process w-100">
                                                                            <div id="total-progress-syllabus"
                                                                                class="progress active w-100"
                                                                                aria-valuemin="0" aria-valuemax="100"
                                                                                aria-valuenow="0">
                                                                                <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                                    role="progressbar"
                                                                                    style="width: 0%;"
                                                                                    data-dz-uploadprogress="">
                                                                                </div>
                                                                            </div>
                                                                        </span>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                                        <div class="d-flex align-items-start gap-2">
                                                                            <div class="w-100 text-center">
                                                                                <x-button
                                                                                    :class="'border btn-light fileinput-button dz-clickable w-100'"
                                                                                    style="height: 100px">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24" fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="feather feather-upload">
                                                                                        <path
                                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                                        <polyline
                                                                                            points="17 8 12 3 7 8" />
                                                                                        <line x1="12" y1="3" x2="12"
                                                                                            y2="15" />
                                                                                    </svg>
                                                                                    <span class="ms-2 fs-5">Add
                                                                                        files</span>
                                                                                </x-button>
                                                                                <small
                                                                                    class="fw-bold form-text text-uppercase mt-2">CHOOSE
                                                                                    OR
                                                                                    DRAG YOUR FILE(s)</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mt-4 col-12 d-flex gap-3 flex-wrap"">
                                                                                                        <button type="
                                                                        submit" id="submit-resource-syllabus"
                                                                        class="btn btn-success flex-shrink-0 d-none">
                                                                        Submit
                                                                        </button>

                                                                        <x-button :class="'btn-danger cancel d-none'">
                                                                            <span>Cancel upload</span>
                                                                        </x-button>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <div class="alert alert-success fade"
                                                                            role="alert">
                                                                            <strong class="submit-resource-alert"
                                                                                id="submit-resource-alert-syllabus"></strong>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <div id="syllabus-iframe-container">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="file-upload-container table-responsive overflow-auto"
                                                                    id="file-upload-container-syllabus">
                                                                    <div class="table table-striped">
                                                                        <div class="d-none">
                                                                            <div id="template-syllabus"
                                                                                class="dropzone-template file-row">
                                                                                <!-- This is used as the file preview template -->
                                                                                <div>
                                                                                    <span class="preview"><img
                                                                                            data-dz-thumbnail /></span>
                                                                                </div>
                                                                                <div>
                                                                                    <p class="name"
                                                                                        data-dz-name></p>
                                                                                    <strong class="error text-danger"
                                                                                        data-dz-errormessage></strong>
                                                                                </div>
                                                                                <div class="file-metadata">
                                                                                    <div class="row">
                                                                                        <x-input name="file[]"
                                                                                            class="file"
                                                                                            hidden>
                                                                                        </x-input>

                                                                                        <div
                                                                                            class="col-12 d-none file-group">
                                                                                            <x-label>Title</x-label>
                                                                                            <x-input name="title[]">
                                                                                            </x-input>
                                                                                        </div>

                                                                                        <div
                                                                                            class="col-12 d-none file-group">
                                                                                            <x-label>Description
                                                                                            </x-label>
                                                                                            <x-input-textarea
                                                                                                name="description[]">
                                                                                            </x-input-textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <p class="size"
                                                                                        data-dz-size></p>
                                                                                    <div class="progress progress-striped active"
                                                                                        role="progressbar"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"
                                                                                        aria-valuenow="0">
                                                                                        <div class="progress-bar progress-bar-success"
                                                                                            style="width:0%;"
                                                                                            data-dz-uploadprogress>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span
                                                                                        class="badge bg-success">Uploaded
                                                                                        successfully</span>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex justify-content-end ps-5">
                                                                                    <x-button
                                                                                        :class="'btn-primary start'">
                                                                                        <span>Start</span>
                                                                                    </x-button>

                                                                                    <x-button data-dz-remove
                                                                                        :class="'btn-warning cancel'">
                                                                                        <span>Cancel</span>
                                                                                    </x-button>

                                                                                    <x-button data-dz-remove
                                                                                        :class="'btn-danger delete'">
                                                                                        <span>Delete</span>
                                                                                    </x-button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropzone-preview previews"
                                                                            id="previews-syllabus">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </x-form-post>
                                                </div>
                                                <div class="tab-pane fade" id="syllabus-upload-storage"
                                                    role="tabpanel">
                                                    <x-form-post action="{{ route('syllabi.uploadByUrl') }}"
                                                        class="storeByUrlForm" onsubmit="event.preventDefault()">
                                                        <div class="row">
                                                            <x-input hidden type="url" name="fileUrl" id="fileUrlInput"
                                                                class="alexusmaiFileUrlInput"></x-input>

                                                            <div class="col-12 mt-3">
                                                                <label class="form-text">Filename</label>
                                                                <span
                                                                    class="alexusmaiFileText h5 text-secondary fw-bold"
                                                                    id="fileText">
                                                                </span>
                                                                <a href="javascript:void(0)"
                                                                    class="openStorageBtn btn btn-link"
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
                                                                <button class="btn btn-success"
                                                                    type="submit">Submit</button>
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
                                    </div>
                                </div>
                                <!-- PREVIEW RESOURCE -->
                                <div class="resource-submit-preview tab-pane fade" id="syllabusSubmitPreview"
                                    role="tabpanel">
                                    <div class="resource-submit-preview-content border border-top-0 rounded p-3"
                                        id="syllabusSubmitPreviewContent">
                                        <div class="alert alert-warning" role="alert">
                                            There is no file being previewed yet.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT PRESENTATION RESOURCE TAB -->
                <div class="submit-resource-tabpane tab-pane fade" id="resource-modal-tabcontent-submit-presentation"
                    role="tabpanel" aria-labelledby="resource-modal-tabcontent-submit-presentation-tab">
                    <div class="pt-4 row">
                        <div class="col-12 col-lg-4">
                            <header class="fs-5 fw-bold">Submit Presentation</header>

                            <ul class="shadow list-group mt-3">
                                <li
                                    class="list-group-item d-flex flex-wrap justify-content-between bg-light text-success">
                                    <span> Recent submissions </span>
                                    <strong id="submit-presentation-log-count"></strong>
                                    <ul id="submit-presentation-log" class="submit-resource-log w-100 list-group mt-3">
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="col-12 col-lg-8">
                            <!-- HIDDEN NAV TABS -->
                            <ul class="nav nav-tabs" id="presentationSubmitTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active resource-submit-form-tab"
                                        id="presentationSubmitFormTab" data-bs-toggle="tab"
                                        data-bs-target="#presentationSubmitForm" type="button"
                                        role="tab">Upload</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link resource-submit-preview-tab"
                                        id="presentationSubmitPreviewTab" data-bs-toggle="tab"
                                        data-bs-target="#presentationSubmitPreview" type="button"
                                        role="tab">Preview</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="presentationSubmitTabcontent">
                                <div class="tab-pane fade show active" id="presentationSubmitForm" role="tabpanel">
                                    <div class="card rounded-0 rounded-bottom border-top-0">
                                        <!-- NAV TABS -->
                                        <header class="card-header py-0">
                                            <ul class="nav nav-pills justify-content-end gap-3" id="pills-tab"
                                                role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link text-dark fw-bold rounded-0 active"
                                                        id="presentation-upload-newfile-tab" data-bs-toggle="pill"
                                                        data-bs-target="#presentation-upload-newfile" type="button"
                                                        role="tab">New file(s)</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                        class="storageUploadStandaloneBtn nav-link text-dark fw-bold rounded-0"
                                                        id="presentation-upload-storage-tab" data-bs-toggle="pill"
                                                        data-bs-target="#presentation-upload-storage" type="button"
                                                        role="tab">
                                                        Storage
                                                    </button>
                                                </li>
                                            </ul>
                                        </header>
                                        <!-- DROPZONE -->
                                        <div class="card-body dropzone">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="presentation-upload-newfile"
                                                    role="tabpanel">
                                                    <x-form-post onsubmit="event.preventDefault()"
                                                        action="{{ route('presentations.upload') }}"
                                                        class="submit-resource-form" id="presentationForm">
                                                        <x-input type="hidden" name="course_id"></x-input>
                                                        <div id="fileMaster-presentation">
                                                            <div class="row-group" id="file-g-presentation">
                                                                <div class="submit-resource-form-actions"
                                                                    id="actions-presentation" class="row g-0">
                                                                    <div class="col-12">
                                                                        <!-- The global file processing state -->
                                                                        <span class="fileupload-process w-100">
                                                                            <div id="total-progress-presentation"
                                                                                class="progress active w-100"
                                                                                aria-valuemin="0" aria-valuemax="100"
                                                                                aria-valuenow="0">
                                                                                <div class="progress-bar progress-bar-striped progress-bar-success"
                                                                                    role="progressbar"
                                                                                    style="width: 0%;"
                                                                                    data-dz-uploadprogress="">
                                                                                </div>
                                                                            </div>
                                                                        </span>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                                        <div class="d-flex align-items-start gap-2">
                                                                            <div class="w-100 text-center">
                                                                                <x-button
                                                                                    :class="'border btn-light fileinput-button dz-clickable w-100'"
                                                                                    style="height: 100px">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24" fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="feather feather-upload">
                                                                                        <path
                                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                                        <polyline
                                                                                            points="17 8 12 3 7 8" />
                                                                                        <line x1="12" y1="3" x2="12"
                                                                                            y2="15" />
                                                                                    </svg>
                                                                                    <span class="ms-2 fs-5">Add
                                                                                        files</span>
                                                                                </x-button>
                                                                                <small
                                                                                    class="fw-bold form-text text-uppercase mt-2">CHOOSE
                                                                                    OR
                                                                                    DRAG YOUR FILE(s)</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mt-4 col-12 d-flex gap-3 flex-wrap"">
                                                                                                        <button type="
                                                                        submit" id="submit-resource-presentation"
                                                                        class="btn btn-success flex-shrink-0 d-none">
                                                                        Submit
                                                                        </button>

                                                                        <x-button :class="'btn-danger cancel d-none'">
                                                                            <span>Cancel upload</span>
                                                                        </x-button>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <div class="alert alert-success fade"
                                                                            role="alert">
                                                                            <strong class="submit-resource-alert"
                                                                                id="submit-resource-alert-presentation"></strong>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <div id="presentation-iframe-container">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="file-upload-container table-responsive overflow-auto"
                                                                    id="file-upload-container-presentation">
                                                                    <div class="table table-striped">
                                                                        <div class="d-none">
                                                                            <div id="template-presentation"
                                                                                class="dropzone-template file-row">
                                                                                <!-- This is used as the file preview template -->
                                                                                <div>
                                                                                    <span class="preview"
                                                                                        style="max-width: 200px">
                                                                                        <img class="w-100"
                                                                                            data-dz-thumbnail />
                                                                                    </span>
                                                                                </div>
                                                                                <div>
                                                                                    <p class="name"
                                                                                        data-dz-name></p>
                                                                                    <strong class="error text-danger"
                                                                                        data-dz-errormessage></strong>
                                                                                </div>
                                                                                <div class="file-metadata">
                                                                                    <div class="row">
                                                                                        <x-input name="file[]"
                                                                                            class="file"
                                                                                            hidden>
                                                                                        </x-input>

                                                                                        <div
                                                                                            class="col-12 d-none file-group">
                                                                                            <x-label>Title</x-label>
                                                                                            <x-input name="title[]">
                                                                                            </x-input>
                                                                                        </div>

                                                                                        <div
                                                                                            class="col-12 d-none file-group">
                                                                                            <x-label>Description
                                                                                            </x-label>
                                                                                            <x-input-textarea
                                                                                                name="description[]">
                                                                                            </x-input-textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <p class="size"
                                                                                        data-dz-size></p>
                                                                                    <div class="progress progress-striped active"
                                                                                        role="progressbar"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"
                                                                                        aria-valuenow="0">
                                                                                        <div class="progress-bar progress-bar-success"
                                                                                            style="width:0%;"
                                                                                            data-dz-uploadprogress>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span
                                                                                        class="badge bg-success">Uploaded
                                                                                        successfully</span>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex justify-content-end ps-5">
                                                                                    <x-button
                                                                                        :class="'btn-primary start'">
                                                                                        <span>Start</span>
                                                                                    </x-button>

                                                                                    <x-button data-dz-remove
                                                                                        :class="'btn-warning cancel'">
                                                                                        <span>Cancel</span>
                                                                                    </x-button>

                                                                                    <x-button data-dz-remove
                                                                                        :class="'btn-danger delete'">
                                                                                        <span>Delete</span>
                                                                                    </x-button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropzone-preview previews"
                                                                            id="previews-presentation">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </x-form-post>
                                                </div>
                                                <div class="tab-pane fade" id="presentation-upload-storage"
                                                    role="tabpanel">
                                                    <x-form-post action="{{ route('presentations.uploadByUrl') }}"
                                                        class="storeByUrlForm" onsubmit="event.preventDefault()">
                                                        <div class="row">
                                                            <x-input hidden type="url" name="fileUrl" id="fileUrlInput"
                                                                class="alexusmaiFileUrlInput"></x-input>

                                                            <div class="col-12 mt-3">
                                                                <label class="form-text">Filename</label>
                                                                <span
                                                                    class="alexusmaiFileText h5 text-secondary fw-bold"
                                                                    id="fileText">
                                                                </span>
                                                                <a href="javascript:void(0)"
                                                                    class="openStorageBtn btn btn-link"
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
                                                                <button class="btn btn-success"
                                                                    type="submit">Submit</button>
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
                                    </div>
                                </div>
                                <!-- PREVIEW RESOURCE -->
                                <div class="resource-submit-preview tab-pane fade" id="presentationSubmitPreview"
                                    role="tabpanel">
                                    <div class="resource-submit-preview-content border border-top-0 rounded p-3"
                                        id="presentationSubmitPreviewContent">
                                        <div class="alert alert-warning" role="alert">
                                            There is no file being previewed yet.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    console.log($(this).val())
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

                    /* ON DRAG FILE */
                    $dropzone.find('.fileinput-button').children().addClass('pe-none')
                    $dropzone.find('.fileinput-button').on(
                        'dragover',
                        function(event) {
                            $(event.target)
                                .addClass('shadow-lg fw-bold')
                                .css('height', '150px')
                        }
                    )
                    $dropzone.find('.fileinput-button').on(
                        'dragleave',
                        function(event) {
                            beforeDragDropzoneStyle(event.target)
                        }
                    )
                    $dropzone.find('.fileinput-button').on(
                        'drop',
                        function(event) {
                            beforeDragDropzoneStyle(event.target)
                            $('#syllabus-iframe-container').html('')
                        }
                    )

                    function beforeDragDropzoneStyle(dropzone) {
                        $(dropzone)
                            .removeClass('shadow-lg fw-bold')
                            .css('height', '100px')
                    }
                })

                $('.submit-resource-tab').on('shown.bs.tab', function(event) {

                })
            })
        </script>
    @endsection
</x-app-layout>
