function getProduct(page, nextPageToken) {
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: `${DOMAIN}/admin/product/get_list_ajax`,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        type: "POST",
        dataType: 'json',
        data: {
            page: page,
            nextPageToken: nextPageToken,
            _token: _token
        }
    }).done(function (data) {
        getProduct(++page, data['data']['nextPageToken'])
    })
}

function getProductInfo() {
    $.ajax({
        url: `${DOMAIN}/admin/product/get_product_info_ajax`,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        type: "GET",
        dataType: 'json',
    }).done(function (data) {
        if (data === true) {
            getProductInfo();
        }
    })
}

getProductInfo()
// getProduct(0)