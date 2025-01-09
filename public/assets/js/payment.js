$(document).ready(async function () {
    await applyVouchers({
        _token: _token
    });

    $('.address_default .update_action').on('click', function () {
        $('#popup_address').css('display', 'flex');
    });

    $('#popup_address .close_btn').on('click', function () {
        $('#popup_address').hide();
    });

    $('#popup_address .address_item .update_action').on('click', function () {
        const selectedAddress = $(this).closest('.address_item');
        const userName = selectedAddress.find('.name').contents().filter(function () {
            return this.nodeType === Node.TEXT_NODE;
        }).text().trim();
        const phone = selectedAddress.find('.name span').text().trim();
        const location = selectedAddress.find('.location').text().trim();

        $('.address_default').attr('address_id', selectedAddress.attr('address_id'));
        $('.address_default .name').html(`${userName} <span>${phone}</span>`);
        $('.address_default .location').text(location);

        $('#popup_address').hide();
    });

    $('#order_submit').on('click', async function (e) {
        const addressId = $('.address_default').attr('address_id');
        if (!addressId) {
            normalAlert('Vui lòng chọn địa chỉ', 'error');
            return;
        }       

        Swal.fire({
            title: 'Xác nhận thanh toán',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ',
            confirmButtonColor: '#4290fb',
            cancelButtonColor: '#b3b3b3',
            background: '#f2f2f2'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const note = $('input[name="note"]').val();
                const shippingFee = 35000;
                const products = [];

                $('.payment_product').each(function () {
                    products.push($(this).attr('product_id'));
                });

                try {
                    const response = await $.ajax({
                        url: `${DOMAIN}/payment/submit`,
                        method: 'POST',
                        data: {
                            note: note,
                            products: products,
                            shipping_fee: shippingFee,
                            address_id: addressId,
                            applied_vouchers: getAppliedVouchers(),
                            _token: _token
                        }
                    });

                    if (response.result) {
                        window.location.href = `${DOMAIN}/user/purchase`;
                    } else {
                        normalAlert(response.error_msg, 'error');
                    }
                } catch (xhr) {
                    normalAlert('Lỗi thanh toán', 'error');
                }
            }
        });
    });

    $('#voucher_select').on('click', function () {
        $('#popup_voucher').css('display', 'flex');
    });

    $('#popup_voucher .close_btn').on('click', function () {
        $('#popup_voucher').hide();
    });

    $('.apply_btn').click(function () {
        const $button = $(this);
        const $voucher_card = $button.closest('.voucher_card');
        const voucherId = $voucher_card.attr('voucher_id');
        const voucherCode = $button.prev('input').val();

        applyVouchers({
            voucher_id: voucherId,
            voucher_code: voucherCode,
            _token: _token
        }, $button);
    });

    async function applyVouchers(data, $button = null) {
        try {
            if ($button) {
                $button.prop('disabled', true).text('Đang áp dụng...');
            }

            const response = await $.ajax({
                url: `${DOMAIN}/payment/apply_voucher`,
                method: 'POST',
                data: data
            });

            if (response.result) {
                if ($button) {
                    normalAlert('Áp dụng thành công', 'success');
                }
                const totalDiscount = response.totalDiscount || 0;
                const totalPrice = response.totalCartValue || 0;

                if (response.appliedVouchers.length > 0) {
                    let voucherDetails = '';
                    response.appliedVouchers.forEach(item => {
                        voucherDetails += `<div class="voucher">- ${new Intl.NumberFormat().format(item.discount)}đ</div>`;
                    });

                    $('.payment_order_detail').html(`
                        <div class="price">${new Intl.NumberFormat().format(totalPrice + 35000)}đ</div>
                        ${voucherDetails}
                        <div class="price final_price">${new Intl.NumberFormat().format(totalPrice + 35000 - totalDiscount)}đ</div>
                    `);

                    $('.voucher_card').each(function () {
                        $(this).find('.apply_btn').text('Chọn');
                        $(this).removeClass('disabled');
                        const voucherId = $(this).attr('voucher_id');
                        if (response.appliedVouchers.some(voucher => voucher.id == voucherId)) {
                            $(this).addClass('disabled');
                            $(this).find('.apply_btn').text('Đã chọn');
                        }
                    });
                } else {
                    $('.payment_order_detail').html(`
                        <div class="price">${new Intl.NumberFormat().format(totalPrice)}đ</div>
                    `);
                }
            } else {
                normalAlert(response.error_msg, 'error');
            }
        } catch (error) {
            normalAlert('Đã có lỗi xảy ra', 'error');
        } finally {
            if ($button) {
                $button.prop('disabled', false).text('Chọn');
                $('#popup_voucher').hide();
            }
        }
    }

    function getAppliedVouchers() {
        const appliedVouchers = [];
        $('.voucher_card.disabled').each(function () {
            appliedVouchers.push($(this).attr('voucher_id'));
        });
        return appliedVouchers;
    }
});