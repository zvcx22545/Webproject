$(document).ready(function () {
    $('.navbar-toggler').click(function () {
        $('#navbarSupportedContent').toggleClass('show');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.navbar-collapse').length && !$(e.target).hasClass('navbar-toggler')) {
            $('#navbarSupportedContent').removeClass('show');
        }
    });
});
