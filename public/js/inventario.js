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
            div.setAttribute('data-id', ingrediente.id_ing);

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
                        <button class="boton-accion editar" data-id="${ingrediente.id_ing}">
                            <i class='bx bx-edit-alt bx-sm'></i>
                        </button>
                        <button class="boton-accion eliminar" data-id="${ingrediente.id_ing}">
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

        document.querySelectorAll(".caja-elemento").forEach(caja => {
            caja.addEventListener("click", abrirPopupIngrediente);
        });
    }

    function cerrarPopup() {
        const blurBox = document.querySelector('.blur-box');
        if (blurBox) {
            blurBox.remove();
        }
    }

    function cerrarPopup() {
        const blurBox = document.querySelector('.blur-box');
        if (blurBox) {
            blurBox.remove(); // Esto elimina el pop-up y el fondo borroso
        }
    }
    
    function abrirPopupIngrediente(event) {
        const id = event.currentTarget.dataset.id; // Obtener ID del ingrediente
        fetch(`/ingredientes/popUp/${id}`) // Llamada a API para obtener datos
            .then(response => response.json())
            .then(ingrediente => {
                console.log(ingrediente); // Verifica la estructura de los datos
                const data = ingrediente.data; // Accede a los datos del ingrediente
    
                // Crear el pop-up de ingrediente
                const blurBox = document.createElement("div");
                blurBox.className = "blur-box";
    
                blurBox.innerHTML = `
                    <div class="popup">
                        <div class="color-header"></div>
                        <div class="popup-header">
                            <h2>${data.nombre}</h2>
                        </div>
                        <hr>
                        <div class="popup-content">
                            <div class="stock-container">
                                <p class="disponible">Disponible</p>
                                <p class="stock">${data.stock}</p>
                            </div>
                            <div class="progress-bar-container">
                                <progress id="progress-bar" class="progress-bar" value="${data.stock}" max="${data.cantidad_total}"></progress>
                            </div>
                            <form class="form-ing">
                                <div class="update-container">
                                    <input class="update-stock" type="number" id="stockQuantity" min="1" value="1">
                                    <div class="buttons-ing">
                                        <button type="button" class="remove button-ing" id="remove">-</button>
                                        <button type="button" class="add button-ing" id="add">+</button>
                                    </div>
                                </div>
                            </form>
                            <div class="btns">
                                <button class="btn-aceptar" id="close-popup">Cerrar</button>
                            </div>
                        </div>
                    </div>
                `;
    
                document.body.appendChild(blurBox);
    
                const stockDisplay = blurBox.querySelector(".stock");
                const progressBar = blurBox.querySelector("progress");
                const inputQuantity = blurBox.querySelector("#stockQuantity");
                const addButton = blurBox.querySelector("#add");
                const removeButton = blurBox.querySelector("#remove");
    
                // Función para actualizar el stock
                function updateStock(operation) {
                    const quantity = parseInt(inputQuantity.value) || 0;
                    if (quantity <= 0) return;
    
                    fetch(`/ingredientes/update/${id}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ cantidad: quantity, operacion: operation })
                    })
                    .then(response => response.json())
                    .then(updatedData => {
                        stockDisplay.textContent = updatedData.stock;
                        progressBar.value = updatedData.stock;
                    })
                    .catch(error => console.error("Error al actualizar stock:", error));
                }
    
                // Event listeners para los botones de agregar y quitar
                addButton.addEventListener("click", () => updateStock("add"));
                removeButton.addEventListener("click", () => updateStock("remove"));
    
                // Evento para cerrar el pop-up
                const closeButton = blurBox.querySelector("#close-popup");
                closeButton.addEventListener("click", cerrarPopup);
    
            })
            .catch(error => console.error("Error al obtener ingrediente:", error));
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

    function eliminarIngrediente(event) {
        const id = event.target.closest("button").dataset.id;
    
        if (confirm("¿Seguro que quieres eliminar este ingrediente?")) {
            fetch(`/ingredientes/delete/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                }
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
