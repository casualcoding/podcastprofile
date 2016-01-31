$(function () {
    var cookie_name = 'podcastprofile_eu_cookie_acceptance';

    if ($.cookie(cookie_name) !== 'yes') {
        $('.cookie-notice').show();
    }

    $('.js-cookie-accept').click(function () {
        $.cookie(cookie_name, 'yes', {expires: 1000});
        $('.cookie-notice').remove();
    });
});
