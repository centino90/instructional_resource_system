require('./bootstrap');

$('.sidebar-menu-btn').click(function () {
    if ($('html').hasClass('sidebar-toggled-hidden')) {
        $('html').removeClass('sidebar-toggled-hidden')
        return
    }
    $('html').addClass('sidebar-toggled-hidden')
});

$('button[type="submit"], input[type="submit"], button.submit')
    .click(function () {
        $(this).addClass('disabled loading');
    })

let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Bootstrap.Tooltip(tooltipTriggerEl)
})

async function createPdf(inputs) {
    var docDefinition = {
        content: [
            {
                alignment: 'center',
                text: 'Syllabus Sample',
                style: 'header',
                fontSize: 20,
                bold: true,
                margin: [0, 10],
            },
            {
                style: 'tableExample',
                layout: {
                    fillColor: function (rowIndex, node, columnIndex) {
                        return (rowIndex === 0) ? '#c2dec2' : null;
                    }
                },
                table: {
                    widths: ['50%', '50%'],
                    headerRows: 1,
                    body: [
                        [
                            {
                                text: `${inputs.firstname} ${inputs.lastname}`,
                                bold: true,
                                colSpan: 2,
                                fontSize: 9,
                            },
                            {
                            }
                        ],
                        [
                            {
                                text: [
                                    'Email: ',
                                    {
                                        text: `${inputs.email}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            },
                            {
                                text: [
                                    'Password: ',
                                    {
                                        text: `${inputs.password}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            }
                        ],
                        [
                            {
                                text: [
                                    'Year level: ',
                                    {
                                        text: `${inputs.year_level}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            },
                            {
                                text: [
                                    'Class description: ',
                                    {
                                        text: `${inputs.class_description}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            }
                        ],
                        [
                            {
                                text: [
                                    'Grade 1st semester: ',
                                    {
                                        text: `${inputs.grade_first_sem}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            },
                            {
                                text: [
                                    'Grade 2nd semester: ',
                                    {
                                        text: `${inputs.grade_second_sem}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            }
                        ],
                        [
                            {
                                text: [
                                    'Section name: ',
                                    {
                                        text: `${inputs.section}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            },
                            {
                                text: [
                                    'No. of students: ',
                                    {
                                        text: `${inputs.student_count}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            }
                        ],
                        [
                            {
                                text: [
                                    'Room no: ',
                                    {
                                        text: `${inputs.room_no}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            },
                            {
                                text: [
                                    'Building no: ',
                                    {
                                        text: `${inputs.building_no}`,
                                        bold: false
                                    }
                                ],
                                fontSize: 9,
                                bold: true
                            }
                        ]
                    ]
                }
            }
        ]
    }

    return pdfMake.createPdf(docDefinition)
}

function getBase64ImageFromURL(url) {
    return new Promise((resolve, reject) => {
        let img = new Image();
        img.setAttribute("crossOrigin", "anonymous");

        img.onload = () => {
            var canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;

            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);

            var dataURL = canvas.toDataURL("image/png");

            resolve(dataURL);
        };

        img.onerror = error => {
            reject(error);
        };

        img.src = url;
    });
}

function getValueOfInputsByFormAndAttribute(form, attribute) {
    if (!form || !attribute) {
        throw new Error('Custom error: parameters are required')
    }

    let formInputsWithoutButtons = form.find(':input:not([type="button"], [type="submit"], [type="reset"], button)')
    let allInputs = {}

    formInputsWithoutButtons.map(function () {
        let attr = $(this).attr(attribute) ?? $(this).attr('id')

        if (!$(this).attr(attribute) && $(this).attr('type') !== 'file') {
            throw new Error(`Custom error: all selected inputs should have this attribute`)
        }

        if ($(this).attr('type') === 'file') {
            $.each(this.files, function (index, file) {
                Object.assign(allInputs, { [attr]: file })
            })
        } else {
            Object.assign(allInputs, { [attr]: $(this).val() })
        }
    })

    return allInputs
}

function setSyllabusFormSubmitWithPdf() {
    $('#dogForm button[type="submit"]').click(function (event) {
        let form = $('#dogForm')
        let formAction = form.attr('action')
        let formSubmitBtn = $(this)
        let formInputs = getValueOfInputsByFormAndAttribute($(form), 'name')
        event.preventDefault()

        createPdf(formInputs)
            .then(res => {
                res.getBlob(blob => {
                    let formData = new FormData()

                    Object.keys(formInputs).forEach(
                        key => formData.append(key, formInputs[key])
                    )

                    formData.append('pdf_data', blob)
                    $.ajax({
                        url: 'http://localhost:8000/dogs/storeAjax',
                        method: "POST",
                        data: formData,
                        enctype: 'multipart/form-data',
                        contentType: false,
                        processData: false,
                        beforeSend: function (xhr) {
                            form.addClass('submitted-once')
                            formSubmitBtn.addClass('btn-loading')
                        }
                    })
                        .done(function (data) {
                            // modal.find('.modal-body').html(data)
                            console.log(data);
                            form.submit();
                            if (data.message === 'success') {
                                location.reload();
                            }
                        })
                        .fail(function (data) {
                            // console.log(data)
                            // alert('error')
                            console.log(data)
                            location.reload();
                            if (data.status === 422) {
                                let response = $.parseJSON(data.responseText)
                                location.reload();
                                // $(modal).find('.alert:eq(0)').fadeIn()
                                // showBackendValidationErrors(form, $(response.errors))
                            }
                        })
                        .always(function () {
                            // setDefaultValidations(form)
                            formSubmitBtn.removeClass('btn-loading')
                        });
                })
            })
    })
}

// function showBackendValidationErrors(form, errors) {
//     let inputs = $(form).find(':input:not([type="button"], [type="submit"], [type="reset"], button)')
//     $.each(inputs, function (index, input) {
//         if (errors[0][$(input).attr('name')]) {
//             $(input).addClass('is-invalid')
//             $(input).next().text(errors[0][$(input).attr('name')])
//         } else {
//             $(input).removeClass('is-invalid')
//         }
//     })
// }

// function setDefaultValidations(form) {
//     let inputs = form.find(':input:not([type="button"], [type="submit"], [type="reset"], button)')
//     $.each(inputs, function (index, input) {
//         $(input).change(function () {
//             if (!$(this).val()) {
//                 $(input).addClass('is-invalid')
//                 $(input).next().text('This field is required!')
//             } else {
//                 $(input).removeClass('is-invalid')
//                 $(input).next().text('')
//             }
//         })
//     })
// }

// setSyllabusFormSubmitWithPdf();
