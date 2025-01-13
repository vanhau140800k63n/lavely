$(document).ready(function () {
    let debounceTimer;

    $('#search_input').on('input', function () {
        const query = $(this).val().trim();
        const suggestionsBox = $('#search_suggestions');

        clearTimeout(debounceTimer);

        if (query.length > 1) {
            debounceTimer = setTimeout(() => {
                $.ajax({
                    url: '/search/suggestions',
                    method: 'GET',
                    data: { q: query },
                    success: function (response) {
                        if (response.result && response.products.length > 0) {
                            const suggestions = response.products.map(item => {
                                const highlightedName = item.name.replace(new RegExp(query, 'gi'), (match) => `<strong>${match}</strong>`);
                                return `<li product_id="${item.id}"> ${highlightedName} </li>`;
                            }).join('');
                            suggestionsBox.find('ul').html(suggestions);
                            suggestionsBox.show();
                        } else {
                            suggestionsBox.find('ul').html('<li>Không tìm thấy kết quả phù hợp</li>');
                            suggestionsBox.show();
                        }
                    }
                });
            }, 300);
        } else {
            suggestionsBox.hide();
        }
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.header_search').length) {
            $('#search_suggestions').hide();
        }
    });

    $(document).on('click', '#search_suggestions li', function () {
        location.href = `${DOMAIN}/product/${$(this).attr('product_id')}`
    });

    $(document).on('click', '.search_btn', function () {
        const searchInput = $('#search_input').val();

        if (searchInput.length >= 2) {
            location.href = `${DOMAIN}/search?keyword=${searchInput}`;
        }
    });
});