/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/setup.js ***!
  \*******************************/
document.addEventListener('DOMContentLoaded', function () {
  window.getExtension = function (filename) {
    var ext = /\.([^.]+)$/.exec(filename);
    return ext == null ? "" : ext[1];
  };

  window.errorAlertGenerator = function (selector, errorMsg) {
    var parentSelector = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
    var $selector = parentSelector ? $(parentSelector).find(selector) : $(selector);
    $selector.html("\n                    <div class=\"alert alert-danger\" role=\"alert\">\n                        <h1>Something went wrong internally!</h1>\n\n                        <p>".concat(errorMsg, "</p>\n\n                        <button class=\"btn btn-primary\" onclick=\"window.location.reload()\">Reload page?</button>\n                    </div>\n                ")).addClass('text-center');
  };

  window.spinnerGenerator = function (selector) {
    var parentSelector = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var removeSpinner = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
    var theme = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 'text-primary';
    var $selector = parentSelector ? $(parentSelector).find(selector) : $(selector);

    if (removeSpinner) {
      $selector.removeClass('text-center');
      $selector.removeClass('disabled'); // $selector.attr('disabled', false)

      $selector.find('.spinner-border').remove();
      return;
    }

    $selector.addClass('disabled'); // $selector.attr('disabled', true)

    $selector.html("\n                    <div class=\"spinner-border ".concat(theme, " mx-auto\" role=\"status\">\n                        <span class=\"visually-hidden\">Loading...</span>\n                    </div>\n                ")).addClass('text-center');
  };

  window.buttonSelectors = function () {
    return 'button[type="submit"]:not(".no-loading"), input[type="submit"]:not(".no-loading"), button.submit';
  };

  $('.sidebar-menu-btn').on('click', function () {
    if ($('html').hasClass('sidebar-toggled-hidden')) {
      $('html').removeClass('sidebar-toggled-hidden');
      return;
    }

    $('html').addClass('sidebar-toggled-hidden');
  });
  $(buttonSelectors()).on('click', function () {
    console.log('yeah');
    spinnerGenerator(this, null, false, 'text-white');
  });
  [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(function (el) {
    return new bootstrap.Tooltip(el);
  });
  [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).forEach(function (el) {
    return new bootstrap.Popover(el);
  });
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
});
/******/ })()
;