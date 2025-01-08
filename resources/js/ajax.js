$(document).ajaxError(function (event, jqXHR, ajaxSettings, thrownError) {
    if (jqXHR.status === 401) {
        Swal.fire({
            title: 'Bạn chưa đăng nhập!',
            text: 'Vui lòng đăng nhập để tiếp tục.',
            icon: 'warning',
            confirmButtonText: 'Đăng nhập',
            confirmButtonColor: '#4290fb'
        }).then(() => {
            window.location.href = `${DOMAIN}/login`;
        });
    } else {
        Swal.fire({
            title: 'Lỗi hệ thống!',
            text: 'Đã xảy ra lỗi, vui lòng thử lại.',
            icon: 'error',
            confirmButtonText: 'Đóng',
            confirmButtonColor: '#d33'
        });
    }
});