$(document).ready(function () {
    $('.user_sidebar a').each(function () {
        if (this.href === window.location.href) {
            $(this).addClass('active');
        }
    });
});