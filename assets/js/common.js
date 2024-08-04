async function ajaxRequest(url, method, data, successCallback, errorCallback) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        success: successCallback,
        error: errorCallback
    });
}

function errorAlert(msg) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: msg,
    })
}

function successAlert(msg) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: msg,
    })
}

