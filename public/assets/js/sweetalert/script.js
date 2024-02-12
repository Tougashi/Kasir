const successButton = "btn btn-success";
const infoButton = "btn btn-info";
const errorButton = "btn btn-danger";
const timeoutAlert = 2000;

function refreshData() {
    $.ajax({
        url: currentUrl,
        method: "GET",
        success: function (response) {
            // console.log(response.data);
            reinitDatatable(response.data);
        },
        error: function (error, xhr) {
            errorAlert(error.message);
            console.log(xhr.responseText);
        },
    });
}

const successAlert = (message) => {
    Swal.fire({
        title: "Berhasil!",
        text: message,
        icon: "success",
        // timer: timeoutAlert,
        customClass: {
            confirmButton: successButton,
        },
    });
};

const info = (message) => {
    Swal.fire({
        title: "Good job!",
        text: message,
        icon: "info",
        // timer: timeoutAlert,
        customClass: {
            confirmButton: infoButton,
        },
    });
};

const deleteModal = (id) => {
    Swal.fire({
        title: "Apakah Anda yakin ?",
        text: "Data ini akan dihapus secara permanen",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya!",
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxDeleteData(id);
        } else {
            info("Data anda tetap disimpan !");
        }
    });
};

const errorAlert = (message) => {
    Swal.fire({
        title: "Terdapat Masalah",
        text: message,
        icon: "error",
        customClass: {
            confirmButton: errorButton,
        },
    });
};
