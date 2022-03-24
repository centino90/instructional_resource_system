require('./bootstrap');
import Dropzone from "dropzone";
Dropzone.autoDiscover = false;

window.getExtension = function (filename){
    var ext = /\.([^.]+)$/.exec(filename);
    return ext == null ? "" : ext[1];
}

window.errorAlertGenerator = function(selector, errorMsg, parentSelector = null)
{
    const $selector = parentSelector ? $(parentSelector).find(selector) : $(selector)

    $selector
            .html(`
                <div class="alert alert-danger" role="alert">
                    <h1>Something went wrong internally!</h1>

                    <p>${errorMsg}</p>

                    <button class="btn btn-primary" onclick="window.location.reload()">Reload page?</button>
                </div>
            `)
            .addClass('text-center')
}

window.spinnerGenerator = function(selector, parentSelector = null, removeSpinner = false, theme = 'text-primary')
{
    const $selector = parentSelector ? $(parentSelector).find(selector) : $(selector)

    if(removeSpinner) {
        $selector.removeClass('text-center')
        $selector.removeClass('disabled')
        // $selector.attr('disabled', false)
        $selector.find('.spinner-border').remove()
        return
    }

    $selector.addClass('disabled')
    // $selector.attr('disabled', true)
    $selector
            .html(`
                <div class="spinner-border ${theme} mx-auto" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `)
            .addClass('text-center')
}

window.buttonSelectors = function() {
    return 'button[type="submit"]:not(".no-loading"), input[type="submit"]:not(".no-loading"), button.submit'
}

$('.sidebar-menu-btn').click(function () {
    if ($('html').hasClass('sidebar-toggled-hidden')) {
        $('html').removeClass('sidebar-toggled-hidden')
        return
    }
    $('html').addClass('sidebar-toggled-hidden')
});

$(buttonSelectors()).click(function () {
    spinnerGenerator(this, null, false, 'text-white')
});

// let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
// let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//     return new Bootstrap.Tooltip(tooltipTriggerEl)
// })

[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  .forEach(el => new bootstrap.Tooltip(el));

[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  .forEach(el => new bootstrap.Popover(el))
