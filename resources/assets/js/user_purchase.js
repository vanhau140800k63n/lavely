$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const filter = urlParams.get('filter') || 'all';

    $('.purchase_search_item').each(function () {
        if ($(this).data('filter') === filter) {
            $(this).addClass('active');
        }
    });

    $('.purchase_search_item').click(function () {
        const selectedFilter = $(this).data('filter');

        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('filter', selectedFilter);
        window.location.href = currentUrl.toString();
    });
});