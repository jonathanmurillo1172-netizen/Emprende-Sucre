//alertas de salir session panel admin
function confirmLogout() {
    Swal.fire({
        title: "¿Cerrar sesión?",
        text: "¿Quieres salir de la plataforma?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, salir",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("logout-form").submit();
        }
    });
}
