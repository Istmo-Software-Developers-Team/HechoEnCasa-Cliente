document.addEventListener('DOMContentLoaded', function () {

    function LoadUnities(){
        fetch("/ingredientes/filters")
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById("filterSelect");
            select.innerHTML = `
                <option value="all">Todos</option>
                <option value="agotados">Agotados</option>
                <option value="casi-agotados">Casi Agotados</option>
            `; 

            data.unidades.forEach(unidad => {
                let option = document.createElement("option");
                option.value = `${unidad.id_unidad}`;
                option.textContent = unidad.nombre_unidad;
                select.appendChild(option);
            });

            window.agotados = new Set(data.agotados);
            window.casiAgotados = new Set(data.casiAgotados);
        })
        .catch(error => console.error("Error cargando filtros:", error));
    }

    LoadUnities()
    
    let ingredientesGlobal = []; 

    function obtenerIngredientes() {
        fetch('/ingredientes/show') 
            .then(response => response.json())
            .then(data => {
                ingredientesGlobal = data; 
                aplicarFiltros(); 
            })
            .catch(error => {
                console.error('Error al obtener los ingredientes:', error);
            });
    }
    
    console.log("Ejemplo de ingrediente:", ingredientesGlobal[0]);

    function aplicarFiltros() {
        let selectedFilter = document.getElementById("filterSelect").value;
        console.log("Filtro seleccionado:", selectedFilter);
        console.log("Ingredientes antes de filtrar:", ingredientesGlobal);
    
        let ingredientesFiltrados = [...ingredientesGlobal];
        
        if (selectedFilter === "agotados") {
            ingredientesFiltrados = ingredientesGlobal.filter(ing => ing.stock <= 0);
        } else if (selectedFilter === "casi-agotados") {
            ingredientesFiltrados = ingredientesGlobal.filter(ing => ing.stock > 0 && ing.stock <= ing.cantidad_min);
        } else if (selectedFilter !== "all") { 
            ingredientesFiltrados = ingredientesGlobal.filter(ing => {
                console.log(`Comparando: ${ing.uni_total} == ${selectedFilter}`);
                return ing.uni_total == selectedFilter;
            });
        }
    
        console.log("Ingredientes después de filtrar:", ingredientesFiltrados);
        mostrarIngredientes(ingredientesFiltrados);
    }
    
    document.getElementById("filterSelect").addEventListener("change", aplicarFiltros);

    function mostrarIngredientes(ingredientes) {
        const listaIngredientes = document.querySelector(".contenedor-elementos");

        listaIngredientes.innerHTML = '';

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

    // Función para cerrar el pop-up
    function cerrarPopup() {
        const blurBox = document.querySelector('.blur-box');
        if (blurBox) {
            blurBox.remove();
        }
    }

    // Función para abrir el pop-up
    function abrirPopupIngrediente(event) {
        const id = event.currentTarget.dataset.id; 
        fetch(`/ingredientes/popUp/${id}`) 
            .then(response => response.json())
            .then(ingrediente => {
                console.log(ingrediente); 
                const data = ingrediente.data; 
    
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
                                <button class="btn-form" id="close-popup">Cerrar</button>
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
    
                addButton.addEventListener("click", () => updateStock("add"));
                removeButton.addEventListener("click", () => updateStock("remove"));
    
                const closeButton = blurBox.querySelector("#close-popup");
                closeButton.addEventListener("click", cerrarPopup);
    
            })
            .catch(error => console.error("Error al obtener ingrediente:", error));
    }    

    function editarIngrediente(event) {
        event.stopPropagation();
        const id = event.currentTarget.dataset.id;
        let blur = document.createElement("div");
        blur.className = "blur-box";
        document.body.appendChild(blur);
    
        let popup = document.createElement("div");
        popup.className = "popup";
    
        popup.innerHTML = `
            <form id="ingredienteForm">
                <input type="text" id="ingName" class="ing-title" placeholder="Ingrediente..." required>
                <div class="input-container">
                    <select id="unidadSelect">
                        <option value="">Cargando...</option>
                    </select>
                </div>
                <div class="input-container">
                    <input type="number" id="initQuantity" placeholder="Cantidad Inicial..." required>
                    <input type="number" id="minQuantity" placeholder="Cantidad mínima..." required>
                </div>
                <div class="btns">
                    <button type="button" class="btn-form" id="close-popup">Cerrar</button>
                    <button type="submit" class="btn-form add" id="updateIng">Actualizar</button>
                </div>
            </form>
        `;
    
        blur.appendChild(popup);
    
        document.getElementById("close-popup").addEventListener("click", function () {
            document.body.removeChild(blur);
        });
    
        fetch(`/ingredientes/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("ingName").value = data.nombre;
                document.getElementById("initQuantity").value = data.stock;
                document.getElementById("minQuantity").value = data.cantidad_min;
    
                fetch('/ingredientes/unities')
                    .then(response => response.json())
                    .then(unidades => {
                        let select = document.getElementById("unidadSelect");
                        select.innerHTML = '<option value="">Seleccione una unidad</option>';
                        unidades.forEach(unidad => {
                            let option = document.createElement("option");
                            option.value = unidad.id_unidad;
                            option.textContent = unidad.nombre_unidad;
                            if (unidad.id_unidad === data.uni_total) {
                                option.selected = true;
                            }
                            select.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Error al cargar unidades:", error));
            })
            .catch(error => console.error("Error al obtener ingrediente:", error));
    
        document.getElementById("ingredienteForm").addEventListener("submit", function (e) {
            e.preventDefault();
    
            let ingName = document.getElementById("ingName").value;
            let unidad = document.getElementById("unidadSelect").value;
            let initQuantity = document.getElementById("initQuantity").value;
            let minQuantity = document.getElementById("minQuantity").value;
    
            let formData = {
                nombre: ingName,
                uni_total: unidad,
                stock: initQuantity,
                cantidad_min: minQuantity
            };

            console.log("Datos enviados:", formData);
    
            fetch(`/ingredientes/${id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                document.body.removeChild(blur);
                obtenerIngredientes();
            })
            .catch(error => console.error("Error al actualizar ingrediente:", error));
        });
    }
    
    // Función para eliminar un ingrediente
    function eliminarIngrediente(event) {
        event.stopPropagation();
        const id = event.target.closest("button").dataset.id;

        let blur = document.createElement("div")
        blur.className = "blur-box"
        document.body.appendChild(blur)

        let popup = document.createElement("div")
        popup.className = "popup-delete"
        
        let confirmDelete = 0
        let cancel = 0;

        popup.innerHTML = 
        `
            <i class='bx bx-error-circle warning-icon bx-md'></i>
            <p class="warning-msg">¿Estás seguro?</p>
            <div class="btns-container">
                <div class="btn-question cancel" id="cancelBtn" >Cancelar</div>
                <div class="btn-question delete" id="deleteBtn" >Eliminar</div>
            </div>
        `

        blur.appendChild(popup)

        let deleteBtn = document.getElementById("deleteBtn")
        let cancelBtn = document.getElementById("cancelBtn")

        deleteBtn.addEventListener("click", () => {
            fetch(`/ingredientes/delete/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                obtenerIngredientes(); 
            })
            .catch(error => console.error("Error al eliminar:", error));
            document.body.removeChild(blur)
        })

        cancelBtn.addEventListener("click", () => {
            document.body.removeChild(blur)
        })
    }

    document.getElementById("botonAgregar").addEventListener("click", () => {
        agregarIngrediente()
    })

    function agregarIngrediente() {
        let blur = document.createElement("div");
        blur.className = "blur-box";
        document.body.appendChild(blur);
    
        let popup = document.createElement("div");
        popup.className = "popup";
    
        popup.innerHTML = `
            <form id="ingredienteForm">
                <input type="text" id="ingName" class="ing-title" placeholder="Ingrediente..." required>
                <hr>
                <div class="input-container">
                    <select id="unidadSelect">
                        <option value="">Cargando...</option>
                    </select>
                    <div class="add button-ing" id="addUnidad">+</div>
                </div>
                <div class="input-container">
                    <input type="number" id="initQuantity" placeholder="Cantidad Inicial..." required>
                    <input type="number" id="minQuantity" placeholder="Cantidad minima..." required>
                </div>
                <div class="btns">
                    <button type="button" class="btn-form" id="close-popup">Cerrar</button>
                    <button type="submit" class="btn-form add" id="addIng">Agregar</button>
                </div>
            </form>
        `;
    
        blur.appendChild(popup);
    
        document.getElementById("close-popup").addEventListener("click", function () {
            document.body.removeChild(blur);
        });

        document.getElementById("addUnidad").addEventListener("click", () => {
            let popup = document.createElement("div")
            popup.className = "popup"

            popup.innerHTML = 
            `
                <form>
                    <div class="input-container">
                        <input type="text" id="unidadNombre" placeholder="Unidad de medida" required>
                        <input type="text" id="unidadAv" placeholder="Abreviación" required>
                        <div class="btns">
                            <button type="button" class="btn-form" id="close-popup-unity">Cerrar</button>
                            <button type="submit" class="btn-form add" id="addUnity">Agregar</button>
                        </div>
                    </div>
                </form>
            `

            let darkBg = document.createElement("div")
            darkBg.className = "dark-bg"
            document.body.appendChild(darkBg)

            darkBg.appendChild(popup)

            document.getElementById("close-popup-unity").addEventListener("click", function () {
                document.body.removeChild(darkBg);
            });

            document.getElementById("addUnity").addEventListener("click", async function (event) {
                event.preventDefault(); 
            
                let nombreUnidad = document.getElementById("unidadNombre").value;
                let abreviacion = document.getElementById("unidadAv").value;
            
                let response = await fetch('/ingredientes/addUnity', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") 
                    },
                    body: JSON.stringify({
                        nombre_unidad: nombreUnidad,
                        abreviacion: abreviacion
                    })
                });
    
            });
            
            
        })
    
        fetch('/ingredientes/unities')
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById("unidadSelect");
                select.innerHTML = '<option value="">Seleccione una unidad</option>';
                data.forEach(unidad => {
                    let option = document.createElement("option");
                    option.value = unidad.id_unidad;
                    option.textContent = unidad.nombre_unidad;
                    select.appendChild(option);
                });

                let addOption = document.createElement("option");
                addOption.value = "addNew";
                addOption.textContent = "Agregar nueva unidad...";
                select.appendChild(addOption);
            })
            .catch(error => console.error("Error al cargar unidades:", error));
    
        document.getElementById("ingredienteForm").addEventListener("submit", function (e) {
            e.preventDefault(); 
    
            let ingName = document.getElementById("ingName").value;
            let unidad = document.getElementById("unidadSelect").value;
            let initQuantity = document.getElementById("initQuantity").value;
            let minQuantity = document.getElementById("minQuantity").value;
    
            let formData = {
                nombre: ingName,
                uni_total: unidad,
                stock: initQuantity,
                cantidad_min: minQuantity
            };
    
            fetch('/ingredientes/agregar', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                document.body.removeChild(blur); 
                obtenerIngredientes(); 
            })
            .catch(error => console.error("Error al agregar ingrediente:", error));
        });
    }
    
    obtenerIngredientes(); 
});
