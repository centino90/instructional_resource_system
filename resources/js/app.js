require('./bootstrap');
import Dropzone from "dropzone";
Dropzone.autoDiscover = false;

$('.sidebar-menu-btn').click(function () {
    if ($('html').hasClass('sidebar-toggled-hidden')) {
        $('html').removeClass('sidebar-toggled-hidden')
        return
    }
    $('html').addClass('sidebar-toggled-hidden')
});

$('button[type="submit"]:not(".no-loading"), input[type="submit"]:not(".no-loading"), button.submit')
    .click(function () {
        $(this).addClass('disabled loading');
    });

// let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
// let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//     return new Bootstrap.Tooltip(tooltipTriggerEl)
// })

[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  .forEach(el => new bootstrap.Tooltip(el));

[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  .forEach(el => new bootstrap.Popover(el))
