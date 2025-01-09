$(document).ready(function () {
    $('.product_detail .image_slider').owlCarousel({
        loop: false,
        margin: 30,
        autoWidth: true,
    });

    $('.image_slider_item').click(function () {
        $('.image_slider_item').removeClass('selected');
        $(this).addClass('selected');
        $('.image_detail').attr('src', $(this).attr('src'));
    })

    $('.quantity_btn').click(function () {
        var input = $(this).siblings('#quantity_input');
        var currentValue = parseInt(input.val());
        var minValue = parseInt(input.attr('min')) || 1;

        if ($(this).hasClass('inc')) {
            input.val(currentValue + 1);
        } else if ($(this).hasClass('dec')) {
            if (currentValue > minValue) {
                input.val(currentValue - 1);
            }
        }
    });

    function checkAllSelected() {
        let allSelected = true;

        $('.product_attr').each(function () {
            if ($(this).find('input[type="radio"]:checked').length === 0) {
                allSelected = false;
            }
        });

        if (allSelected) {
            $('#buy_now').prop('disabled', false);
            $('#add_to_cart').prop('disabled', false);
        } else {
            $('#buy_now').prop('disabled', true);
            $('#add_to_cart').prop('disabled', true);
        }
    }

    $('input[type="radio"]').on('change', function () {
        checkAllSelected();
    });

    $('#add_to_cart').click(function () {
        let prodAttrVal = [];
        $('.product_attr').each(function () {
            prodAttrVal.push($(this).find('input[type="radio"]:checked').val());
        });

        const productData = {
            prodAttrVal: prodAttrVal,
            productId: $('.product_detail').attr('product_id'),
            quantity: $('#quantity_input').val(),
            _token: _token
        };

        $.ajax({
            url: `${DOMAIN}/cart/add`,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            type: "POST",
            dataType: 'json',
            data: productData
        }).done(function (data) {
            data['result'] ? alertSuccess() : alertError();
        }).fail(function (error) {
            if (error.status === 401 || error.status === 403) {
                window.location.href = `${DOMAIN}/login`;
            } else {
                alertError();
            }
        })
    });

    function alertSuccess() {
        Swal.fire({
            title: 'Thêm sản phẩm thành công!',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Giỏ hàng',
            cancelButtonText: 'Tiếp tục mua sắm',
            confirmButtonColor: '#4290fb',
            cancelButtonColor: '#b3b3b3',
            background: '#f2f2f2',
            customClass: {
                popup: 'custom-popup-class',
                title: 'custom-title-class',
                confirmButton: 'custom-confirm-button-class',
                cancelButton: 'custom-cancel-button-class'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `${DOMAIN}/cart`;
            }
        });
    }

    function alertError() {
        Swal.fire({
            title: 'Thêm vào giỏ hàng thất bại!',
            text: 'Rất tiếc, có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.',
            icon: 'error',
            background: '#fefefe',
            showConfirmButton: false,
            customClass: {
                popup: 'error-popup-class',
                title: 'error-title-class',
            },
            timer: 3000,
            timerProgressBar: true,
        });
    }
});