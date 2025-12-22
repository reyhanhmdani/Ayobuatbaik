import "./bootstrap";
import Swal from "sweetalert2";

window.Swal = Swal;

window.confirmDelete = function (formId, message = "Data yang dihapus tidak dapat dikembalikan!") {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: message,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
};
