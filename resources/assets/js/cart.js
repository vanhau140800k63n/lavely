$(document).ready(async function () {
    const $totalQuantity = $('.total_quantity');
    const $totalPrice = $('.total_price');
    const cartUpdateUrl = `${DOMAIN}/cart/update`;
    const cartDeleteUrl = `${DOMAIN}/cart/delete/`;

    updateCartTotal();

    $('.quantity_btn').click(async function () {
        disableAction();

        const quantityInput = $(this).siblings('input[name="quantity_input"]');
        const minValue = parseInt(quantityInput.attr('min')) || 1;
        const priceElement = $(this).closest('.cart_product').find('.cart_product_price .price_default');
        const totalElement = $(this).closest('.cart_product').find('.cart_product_price_total');
        const price = parseInt(priceElement.text().replace(/[^0-9]/g, ''));
        const action = $(this).attr('action');
        const cartItemId = $(this).closest('.cart_item').attr('id');

        if (action == 1 && parseInt(quantityInput.val()) <= minValue) {
            activeAction();
            return;
        }

        try {
            const response = await updateCartProduct({
                action,
                cartItemId,
                _token: _token
            });

            if (!response || !response.result) {
                normalAlert('Lỗi khi cập nhật sản phẩm', 'error');
                return;
            }

            const newQuantity = parseInt(response.quantity);
            const newTotal = price * newQuantity;
            quantityInput.val(newQuantity);
            totalElement.text(formatCurrency(newTotal));
            updateCartTotal();
        } catch (error) {
            normalAlert('Lỗi khi cập nhật sản phẩm', 'error');
        } finally {
            activeAction();
        }
    });

    $('.product_checkbox').change(updateCartTotal);

    $('.cart_product_del button').click(function () {
        disableAction();
        const cartItem = $(this).closest('.cart_item');
        const cartItemId = cartItem.attr('id');

        $.ajax({
            url: `${cartDeleteUrl}${cartItemId}`,
            type: 'DELETE',
            data: { _token },
            success: function (response) {
                if (response.result) {
                    cartItem.remove();
                    normalAlert('Xóa sản phẩm thành công!', 'success');
                } else {
                    normalAlert(response.message || 'Vui lòng thử lại.', 'error');
                }
                updateCartTotal();
            },
            error: function () {
                normalAlert('Lỗi khi xóa sản phẩm', 'error');
            },
            complete: activeAction
        });
    });

    function updateCartTotal() {
        let totalQuantity = 0;
        let totalPrice = 0;

        $('.cart_product').each(function () {
            if ($(this).find('.product_checkbox').is(':checked')) {
                const quantity = parseInt($(this).find('input[name="quantity_input"]').val());
                const price = parseInt($(this).find('.cart_product_price .price_default').text().replace(/[^0-9]/g, ''));
                totalQuantity += quantity;
                totalPrice += quantity * price;
            }
        });

        $totalQuantity.text(totalQuantity);
        $totalPrice.text(formatCurrency(totalPrice));
    }

    function disableAction() {
        $('.cart_detail button').prop('disabled', true);
    }

    function activeAction() {
        $('.cart_detail button').prop('disabled', false);
    }

    async function updateCartProduct(data) {
        try {
            return await $.ajax({
                url: cartUpdateUrl,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                type: "POST",
                dataType: 'json',
                data
            });
        } catch (error) {
            console.error("Cập nhật sản phẩm lỗi:", error);
            return false;
        }
    }

    function formatCurrency(value) {
        return value.toLocaleString('vi-VN');
    }

    $('#cart_payment').click(function () {
        const cartItems = $('input[name="cart_product_input"]:checked').map(function () {
            return this.value;
        }).get();

        if (cartItems.length === 0) {
            normalAlert('Hãy chọn ít nhất 1 sản phẩm', 'error');
            return;
        }


        $.ajax({
            url: `${DOMAIN}/cart/checkout`,
            type: 'POST',
            data: {
                cartItems: cartItems,
                _token: _token
            },
            success: function (response) {
                if (response.result) {
                    location.href = `${DOMAIN}/payment`;
                    return;
                } else {
                    normalAlert(response.error_msg, 'error');
                }
            },
            error: function () {
                normalAlert('Có lỗi xảy ra. Vui lòng thử lại', 'error');
            }
        });
    })
});