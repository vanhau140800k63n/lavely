function normalAlert(message, icon = 'info') {
    Swal.fire({
        title: message,
        icon,
        timer: 2000,
        showConfirmButton: false
    });
}

const callbackAlert = (title, text, icon, callback = null) => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'Đóng',
        confirmButtonColor: '#4290fb',
    }).then(() => {
        if (callback) callback();
    });
};