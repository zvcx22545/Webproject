$(document).ready(function () {
    $('#navbar-toggler').click(function () {
        $('#navbarSupportedContent').toggleClass('show');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.hamburger').length && !$(e.target).closest('#navbarSupportedContent').length) {
            $('#navbarSupportedContent').removeClass('show');
        }
    });
});
