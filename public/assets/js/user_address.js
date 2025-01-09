$(document).ready(function () {
    const reloadDropdown = (selector, defaultOptionText, data) => {
        let options = defaultOptionText != undefined ? `<option value="0">${defaultOptionText}</option>` : '';
        if (data) {
            options += data;
        }
        $(selector).html(options);
    };

    $('#add_address').click(async () => {
        $('#add_address_btn').show();
        $('#update_address_btn').hide();
        $('#popup_form h2').text('Thêm địa chỉ');
        $('#province_select').val(0);
        $('input').val('');
        await setDistricts(0);
        $('#popup_form').css('display', 'flex');
    });

    $('#close_popup').click(() => {
        $('#popup_form').hide();
    });

    $('#province_select').change(function () {
        setDistricts($(this).val());
    });

    async function setDistricts(provinceValue) {
        if (!provinceValue || provinceValue === "0") {
            reloadDropdown('#district_select', 'Chọn quận huyện');
            reloadDropdown('#commune_select', 'Chọn xã phường');
            return;
        }

        reloadDropdown('#district_select', 'Đang tải...');
        reloadDropdown('#commune_select', 'Chọn xã phường');

        try {
            const data = await $.get(`${DOMAIN}/user/address/district?province=${provinceValue}`);
            reloadDropdown('#district_select', 'Chọn quận huyện', data);
        } catch {
            reloadDropdown('#district_select', 'Chọn quận huyện');
        }
    }

    $('#district_select').change(async function () {
        setCommunes($(this).val());
    });

    async function setCommunes(districtValue) {
        if (!districtValue || districtValue === "0") {
            reloadDropdown('#commune_select', 'Không có dữ liệu');
            return;
        }

        reloadDropdown('#commune_select', 'Đang tải...');

        try {
            const data = await $.get(`${DOMAIN}/user/address/commune?district=${districtValue}`);
            reloadDropdown('#commune_select', undefined, data);
        } catch {
            reloadDropdown('#commune_select', 'Không có dữ liệu');
        }
    }

    $('#add_address_btn').click(async function () {
        if ($('#province_select').val() == 0 || $('#district_select').val() == 0 || $('#commune_select').val() == 0) {
            $('.error_text').html('Thiếu thông tin');
            return;
        }

        const formData = {
            name: $('input[name="name"]').val(),
            phone: $('input[name="phone"]').val(),
            province: $('#province_select option:selected').val(),
            district: $('#district_select option:selected').val(),
            commune: $('#commune_select option:selected').val(),
            address_detail: $('input[name="address_detail"]').val(),
            _token: _token,
        };

        try {
            const data = await $.ajax({
                url: `${DOMAIN}/user/address/add`,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                type: 'POST',
                dataType: 'json',
                data: formData,
            });

            if (!data.result) {
                $('.error_text').html(data.error_msg);
            } else {
                callbackAlert('Thành công', 'Địa chỉ đã được thêm', 'success', () => {
                    window.location.reload();
                });
            }
        } catch {
            $('.error_text').html('Thêm không thành công. Vui lòng thử lại.');
        }
    });

    $('.del_action').click(function () {
        const addressId = $(this).data('id');

        Swal.fire({
            title: 'Bạn có chắc muốn xóa địa chỉ này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#4290fb',
            cancelButtonColor: '#b3b3b3',
            background: '#f2f2f2',
            customClass: {
                popup: 'custom-popup-class',
                title: 'custom-title-class',
                confirmButton: 'custom-confirm-button-class',
                cancelButton: 'custom-cancel-button-class',
            },
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const data = await $.ajax({
                        url: `${DOMAIN}/user/address/delete/${addressId}`,
                        headers: { 'X-CSRF-TOKEN': _token },
                        type: 'DELETE',
                        dataType: 'json',
                    });

                    if (data.result) {
                        callbackAlert('Thành công', 'Địa chỉ đã được xóa', 'success', () => {
                            window.location.reload();
                        });
                    } else {
                        normalAlert(data.error_msg, 'error');
                    }
                } catch {
                    normalAlert('Lỗi hệ thống. Vui lòng thử lại.', 'error');
                }
            }
        });
    });

    $('.update_action').click(async function () {
        const addressId = $(this).data('id');
        if (!addressId)
            return;
        $('#popup_form h2').text('Cập nhật địa chỉ');

        try {
            const data = await $.get(`${DOMAIN}/user/address/get/${addressId}`);

            $('input[name="name"]').val(data.user_name);
            $('input[name="phone"]').val(data.phone);

            // select province
            $('#province_select').val(data.province);
            await setDistricts(data.province);

            // select district
            $('#district_select').val(data.district);
            await setCommunes(data.district);

            // select commune
            $('#commune_select').val(data.commune);

            $('input[name="address_detail"]').val(data.address_detail);

            $('#add_address_btn').hide();
            $('#update_address_btn').show().data('id', addressId);

            $('#popup_form').css('display', 'flex');
        } catch (error) {
            normalAlert('Không thể tải dữ liệu. Vui lòng thử lại.', 'error');
        }
    });

    $('#update_address_btn').click(async function () {
        const addressId = $(this).data('id');

        const formData = {
            name: $('input[name="name"]').val(),
            phone: $('input[name="phone"]').val(),
            province: $('#province_select option:selected').val(),
            district: $('#district_select option:selected').val(),
            commune: $('#commune_select option:selected').val(),
            address_detail: $('input[name="address_detail"]').val(),
            _token: _token,
        };

        try {
            const data = await $.ajax({
                url: `${DOMAIN}/user/address/update/${addressId}`,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                type: 'PUT',
                dataType: 'json',
                data: formData,
            });

            if (data.result) {
                callbackAlert('Thành công', 'Địa chỉ đã được cập nhật', 'success', () => {
                    window.location.reload();
                });
            } else {
                $('.error_text').html(data.error_msg);
            }
        } catch (error) {
            $('.error_text').html('Lỗi hệ thống. Vui lòng thử lại.');
        }
    });
});