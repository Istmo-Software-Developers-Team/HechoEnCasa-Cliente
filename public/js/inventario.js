document.addEventListener('DOMContentLoaded', function () {
    // Función para obtener los ingredientes desde la API (Laravel)
    function obtenerIngredientes() {
        fetch('/ingredientes/show') // API Laravel
            .then(response => response.json())
            .then(data => {
                mostrarIngredientes(data);
            })
            .catch(error => {
                console.error('Error al obtener los ingredientes:', error);
            });
    }
    
    // Función para mostrar los ingredientes en el HTML
    function mostrarIngredientes(ingredientes) {
        const listaIngredientes = document.querySelector(".contenedor-elementos");

        listaIngredientes.innerHTML = ''; // Limpiar antes de agregar nuevos

        ingredientes.forEach(ingrediente => {
            const div = document.createElement('div');
            div.classList.add('caja-elemento');

            const header = document.createElement('div');
            header.classList.add('color-header');

            if (ingrediente.stock <= 0) {
                div.classList.add('rojo');
            } else if (ingrediente.stock <= ingrediente.cantidad_min) {
                div.classList.add('amarillo');
            }

            div.appendChild(header);

            // Crear estructura con botones de acción
            div.innerHTML += `
                <div class="nombre-acciones">
                    <h2 class="nombre-ingrediente">${ingrediente.nombre}</h2>
                    <div class="acciones">
                        <button class="boton-accion editar" data-id="${ingrediente.id}">
                            <i class='bx bx-edit-alt bx-sm'></i>
                        </button>
                        <button class="boton-accion eliminar" data-id="${ingrediente.id}">
                            <i class='bx bx-trash bx-sm'></i>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="cantidad-unidad">
                    <span>Stock: ${ingrediente.stock}</span>
                    <span>${ingrediente.nombre_unidad}</span>                        
                </div>
            `;

            listaIngredientes.appendChild(div);
        });

        // Agregar eventos a los botones de Editar y Eliminar
        document.querySelectorAll(".editar").forEach(boton => {
            boton.addEventListener("click", editarIngrediente);
        });

        document.querySelectorAll(".eliminar").forEach(boton => {
            boton.addEventListener("click", eliminarIngrediente);
        });
    }

    // Función para editar el nombre del ingrediente
    function editarIngrediente(event) {
        const id = event.target.closest("button").dataset.id;
        const nuevoNombre = prompt("Ingresa el nuevo nombre del ingrediente:");

        if (nuevoNombre) {
            fetch(`/ingredientes/update/${id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ nombre: nuevoNombre })
            })
            .then(response => response.json())
            .then(data => {
                alert("Ingrediente actualizado correctamente");
                obtenerIngredientes(); // Recargar la lista
            })
            .catch(error => console.error("Error al actualizar:", error));
        }
    }

    // Función para eliminar un ingrediente
    function eliminarIngrediente(event) {
        const id = event.target.closest("button").dataset.id;

        if (confirm("¿Seguro que quieres eliminar este ingrediente?")) {
            fetch(`/ingredientes/delete/${id}`, {
                method: "DELETE",
            })
            .then(response => response.json())
            .then(data => {
                alert("Ingrediente eliminado");
                obtenerIngredientes(); // Recargar la lista
            })
            .catch(error => console.error("Error al eliminar:", error));
        }
    }

    obtenerIngredientes(); // Cargar ingredientes al inicio
});
