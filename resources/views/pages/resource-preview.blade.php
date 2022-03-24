<x-app-layout>
    <x-slot name="header">
        Preview
    </x-slot>

    <x-slot name="headerTitle">
        Page action
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('resource.show', $resource->id) }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Courses</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('course.show', $resource->course->id) }}">{{ $resource->course->code }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><a
                href="{{ route('resource.show', $resource->id) }}">{{ $resource->title }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">preview</li>
    </x-slot>

    <div class="row">
        <div class="col-lg-3">
            <x-real.card>
                <x-slot name="header">
                    Some actions
                </x-slot>

                <x-slot name="body">
                    <div class="gap-2 d-lg-grid">
                        <button class="btn btn-secondary">Fullscreen</button>
                        <button class="btn btn-primary">Download Original</button>
                        <button class="btn btn-danger">Download as PDF</button>
                    </div>
                </x-slot>
            </x-real.card>
        </div>

        <div class="col-lg-9">
            <x-real.card>
                <x-slot name="header">
                    {{ $media->file_name }}
                </x-slot>

                <x-slot name="label">
                    Filename
                </x-slot>

                <x-slot name="body">
                    <div id="previewContainer" class="col-12 mt-2"></div>
                </x-slot>
            </x-real.card>
        </div>
    </div>


    @section('script')
        <script>
            $(document).ready(function() {
                let previewFiletype = '{{ $fileType ?? '' }}'
                let previewResourceUrl = `{!! $resourceUrl ?? '' !!}`
                let previewResourceText = `{!! $resourceText ?? '' !!}`
                let hasErrors = `{{ $errors->any() }}`
                let errorMsg = `{{ $errors->first('message') }}`

                if (hasErrors) {
                    $('#previewContainer').append(`
                    <div class="alert alert-danger my-0">
                        <strong>Error Message!</strong> ${errorMsg}
                    </div>
                    `)
                } else {
                    if (previewFiletype === 'text_filetypes') {
                        CodeMirror.defineSimpleMode("simple", {
                            // The start state contains the rules that are intially used
                            start: [
                                // The regex matches the token, the token property contains the type
                                {
                                    regex: /(function)(\s+)([a-z$][\w$]*)/,
                                    token: ["keyword", null, "variable-2"]
                                },
                                // Rules are matched in the order in which they appear, so there is
                                // no ambiguity between this one and the one above
                                {
                                    regex: /(?:function|class|extends|var|let|const|CONST|define|return|if|for|while|else|do|this|def)\b/,
                                    token: "keyword"
                                },
                                {
                                    regex: /true|false|null|undefined/,
                                    token: "atom"
                                },
                                {
                                    regex: /0x[a-f\d]+|[-+]?(?:\.\d+|\d+\.?\d*)(?:e[-+]?\d+)?/i,
                                    token: "number"
                                },
                                {
                                    regex: /["'](?:[^\\]|\\.)*?(?:["']|$)/,
                                    token: "string"
                                },
                                {
                                    regex: /;.*/,
                                    token: "comment"
                                },
                                {
                                    regex: /\/\*/,
                                    token: "comment",
                                    next: "comment"
                                },
                                {
                                    regex: /#.*/,
                                    token: "comment"
                                },
                                {
                                    regex: /--.*/,
                                    token: "comment"
                                },
                                {
                                    regex: /[a-z$][\w$]*/,
                                    token: "variable"
                                },

                                {
                                    regex: /[-+\/*=<>!]+/,
                                    token: "operator"
                                },
                                {
                                    regex: /[\{\[\(]/,
                                    indent: true
                                },
                                {
                                    regex: /[\}\]\)]/,
                                    dedent: true
                                },

                                //Trying to define keywords here
                                {
                                    regex: /\b(?:timer|counter|version)\b/gi,
                                    token: "keyword"
                                } // gi for case insensitive
                            ],
                            // The multi-line comment state.
                            comment: [{
                                    regex: /.*?\*\//,
                                    token: "comment",
                                    next: "start"
                                },
                                {
                                    regex: /.*/,
                                    token: "comment"
                                }
                            ],
                            meta: {
                                dontIndentStates: ["comment"],
                                lineComment: ";"
                            }
                        })

                        let cm = CodeMirror(document.querySelector('#previewContainer'), {
                            mode: 'simple',
                            lineNumbers: true,
                            tabSize: 5,
                            readOnly: true,
                            lineWrapping: true
                        })

                        cm.setValue(previewResourceText);
                        setTimeout(function() {
                            cm.refresh();
                        }, 1)
                        $('#previewContainer .CodeMirror').addClass('h-auto')
                        $('#previewContainer').closest('.card-body').addClass('px-0')
                    }

                    if (previewFiletype === 'img_filetypes') {
                        $('#previewContainer').append(
                            `<img style="width: 100%" src="${previewResourceUrl}" />`
                        )
                    }

                    if (previewFiletype === 'pdf_convertible_filetypes') {
                        console.log()
                        $('#previewContainer').append(
                            `<iframe src="${previewResourceUrl}" class="w-100" height="600"></iframe>`
                        )
                    }

                    if (previewFiletype === 'word_filetypes') {
                        $('#previewContainer').append(
                            `<iframe src="${previewResourceUrl}" class="w-100" height="600"></iframe>`
                        )
                    }

                    if (previewFiletype === 'spreadsheet_filetypes') {
                        const ul = $(`<ul class="mt-4 nav nav-tabs" id="myTab" role="tablist"></ul>`)
                        const tabContent = $('<div class="tab-content pt-4" id="myTabContent"></div>')
                        $($.parseJSON(previewResourceUrl)).each(function(index, item) {

                            const li = $(`
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ${index == 0 ? 'active' : ''}" id="tab-${index}" data-bs-toggle="tab" data-bs-target="#target-${index}" type="button" role="tab">Tab ${index + 1}</button>
                            </li>
                            `)
                            const tabpane = $(
                                `<div class="table-responsive tab-pane fade ${index == 0 ? 'show active' : ''}" id="target-${index}" role="tabpanel"></div>`
                            )
                            const table = $(
                                '<table class="table table-bordered table-hovered table-sm"></table>')
                            const thead = $('<thead></thead>')
                            const tbody = $('<tbody></tbody>')

                            $(item).each(function(index, item) {
                                $red = item.reduce((acc, cur) => {
                                    return acc +=
                                        `<td class="text-nowrap overflow-hidden px-2" style="max-width: 150px">${cur ?? ''}</td>`;
                                })
                                if (index <= 0) {
                                    thead.append(`<tr class="fw-bold">${$red}</tr>`);
                                } else {
                                    tbody.append(`<tr>${$red}</tr>`);
                                }
                            })

                            table.append(thead)
                            table.append(tbody)

                            tabpane.append(table)

                            ul.append(li)
                            tabContent.append(tabpane)
                        })
                        $('#previewContainer').append(ul)
                        $('#previewContainer').append(tabContent)
                        $('table').DataTable()
                    }

                    if (previewFiletype === 'video_filetypes') {
                        $('#previewContainer').append(
                            `<video width="320" height="240" controls autoplay>
                                                <source src="${previewResourceUrl}" type="video/mp4">
                                            </video>`
                        )
                    }

                    if (previewFiletype === 'audio_filetypes') {
                        $('#previewContainer').append(
                            `<audio controls autoplay>
                                                <source src="${previewResourceUrl}" type="audio/mpeg">
                                            </audio>`
                        )
                    }
                }
            })
        </script>
    @endsection
</x-app-layout>
