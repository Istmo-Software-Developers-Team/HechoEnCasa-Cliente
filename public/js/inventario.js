document.addEventListener('DOMContentLoaded', function() {
    // Función para obtener los ingredientes desde la API (Laravel)
    function obtenerIngredientes() {
        fetch('/ingredientes/show')  // Aquí es donde la API estará disponible
            .then(response => response.json())
            .then(data => {
                // Llamar a la función para mostrar los ingredientes
                mostrarIngredientes(data);
            })
            .catch(error => {
                console.error('Error al obtener los ingredientes:', error);
            });
    }

    // Función para mostrar los ingredientes en el HTML
    function mostrarIngredientes(ingredientes) {
        const listaIngredientes = document.querySelector(".contenedor-elementos");

        // Limpiar la lista antes de agregar nuevos elementos
        listaIngredientes.innerHTML = '';

        // Iterar sobre los ingredientes y agregarlos al DOM
        ingredientes.forEach(ingrediente => {
            const div = document.createElement('div');
            div.classList.add('caja-elemento'); // Agregar clase para estilo general

            // Añadir el header de color (se colocará arriba)
            const header = document.createElement('div');
            header.classList.add('color-header');

            // Determinar el color del header basado en el stock
            if (ingrediente.stock <= 0) {
                div.classList.add('rojo');  // Clase para ingredientes con bajo stock// Color del header rojo
            } else if(ingrediente.stock <= ingrediente.cantidad_min){
                div.classList.add('amarillo');
            }

            // Agregar el header a la caja de elemento
            div.appendChild(header);

            // Agregar el contenido con las clases necesarias
            div.innerHTML += `
                <div class="nombre-acciones">
                    <h2>${ingrediente.nombre}</h2>
                    <div class="acciones">
                        <button class="boton-accion"><i class='bx bx-edit-alt bx-sm'></i></button>
                        <button class="boton-accion"><i class='bx bx-trash bx-sm' ></i></button>
                    </div>
                </div>
                <hr>
                <div class="cantidad-unidad">
                    <span>Stock: ${ingrediente.stock}</span>
                    <span>${ingrediente.nombre_unidad}</span>                        
                </div>

            `;

            // Añadir el nuevo ingrediente al contenedor
            listaIngredientes.appendChild(div);
            
        });
    }

    // Llamar a la función para obtener los ingredientes cuando la página cargue
    obtenerIngredientes();
});
