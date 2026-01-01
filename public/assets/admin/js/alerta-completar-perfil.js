//ALERTA PARA CUANDO COMPLETA EL PERFIL Y ENVIA CON DATOS FALTANTES
// Valido el formulario antes de enviar para evitar recargas innecesarias
document.getElementById("profileForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let phone = document.querySelector('input[name="phone"]').value.trim();
    let description = document
        .querySelector('textarea[name="description"]')
        .value.trim();
    let genderInput = document.querySelector('input[name="gender"]');
    let isValid = true;
    let errorMessage = "Por favor completa todos los campos requeridos.";

    // Validar Teléfono
    if (!phone) {
        isValid = false;
    }

    // Validar Descripción (si se requiere)
    if (!description) {
        isValid = false;
    }

    // Validar Género (solo si existe el input, es decir, es emprendedor)
    if (genderInput && !genderInput.value) {
        isValid = false;
    }

    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Campos Incompletos",
            text: errorMessage,
            confirmButtonText: "Entendido",
            confirmButtonColor: "#4f46e5",
        });
    } else {
        this.submit();
    }
});
