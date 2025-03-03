document.addEventListener('DOMContentLoaded', function() {
    // Función para obtener los ingredientes desde la API (Laravel)
    function obtenerIngredientes() {
        fetch('/ingredientes')  // Aquí es donde la API estará disponible
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
        const listaIngredientes = document.getElementById('ingredientes-lista');

        // Limpiar la lista antes de agregar nuevos elementos
        listaIngredientes.innerHTML = '';

        // Iterar sobre los ingredientes y agregarlos al DOM
        ingredientes.forEach(ingrediente => {
            if (ingrediente.stock > 0) {
                const div = document.createElement('div');
                div.classList.add('ingrediente-item');
                div.innerHTML = `
                    <p><strong>${ingrediente.nombre}</strong></p>
                    <p>Unidad: ${ingrediente.nombre_unidad}</p>
                    <p>Stock: ${ingrediente.stock}</p>
                `;
                listaIngredientes.appendChild(div);
            }
        });
    }

    // Llamar a la función para obtener los ingredientes cuando la página cargue
    obtenerIngredientes();
});
