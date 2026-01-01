//ALERTA CAMPOS VACIOS CATEGORIAS DEL ARCHIVO categoria.blade.php
// Validación antes de enviar el formulario previniendo el envio de datos vacios

document
    .getElementById("createCategoryForm")
    .addEventListener("submit", function (e) {
        const name = document.getElementById("catName").value.trim();
        const desc = document.getElementById("catDesc").value.trim();
        // Si algún campo está vacío, previene el envío del formulario
        if (!name || !desc) {
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "Campos incompletos",
                text: "Por favor, ingresa tanto el nombre como la descripción de la categoría.",
                confirmButtonColor: "#4f46e5",
            });
        }
    });

//ALERTA PARA ELIMINAR CATEGORIA
const swalWithCustomButtons = Swal.mixin({
    customClass: {
        confirmButton:
            "bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition",
        cancelButton:
            "bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow transition mr-2",
    },
    buttonsStyling: false,
});

// Función de confirmación para eliminar categoría con advertencia de emprendimientos
function confirmDelete(categoryId, categoryName, venturesCount) {
    // Mensaje dinámico según el número de emprendimientos
    let warningText = "";

    if (venturesCount > 0) {
        warningText = `Esta categoría tiene <strong>${venturesCount} emprendimiento(s)</strong> relacionado(s). Al eliminarla, estos emprendimientos quedarán sin categoría.`;
    } else {
        warningText = "Esta acción eliminará la categoría permanentemente.";
    }

    swalWithCustomButtons
        .fire({
            title: `¿Eliminar "${categoryName}"?`,
            html: warningText,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario para eliminar
                document.getElementById("delete-form-" + categoryId).submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithCustomButtons.fire({
                    title: "Cancelado",
                    text: "La categoría está a salvo",
                    icon: "error",
                });
            }
        });
}

//buscar en vivo

// BUSCADOR EN VIVO
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector('input[name="search"]');
    let debounceTimer;

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            clearTimeout(debounceTimer);

            const query = this.value;

            debounceTimer = setTimeout(() => {
                fetch(`{{ route('admin.categoria.index') }}?search=${query}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then((response) => response.text())
                    .then((html) => {
                        // Re-seleccionar el contenedor actual del DOM
                        const currentTable =
                            document.querySelector("#table-container");
                        if (currentTable) {
                            currentTable.outerHTML = html;
                        }
                    })
                    .catch((error) => console.error("Error:", error));

                // Actualizar URL
                const url = new URL(window.location);
                if (query) {
                    url.searchParams.set("search", query);
                } else {
                    url.searchParams.delete("search");
                }
                window.history.pushState({}, "", url);
            }, 300);
        });
    }
});
