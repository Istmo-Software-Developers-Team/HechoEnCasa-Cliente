<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas</title>
    <link rel="stylesheet" href="{{ asset('css/recipe.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div class="all">
      <div class="search">
        <input type="text" placeholder="Search">
      </div>
      <div class="cosas">
        <div class="sidebar">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
        <div class="container">
            <div class="head">
                <div class="search-container">
                    <input type="text" placeholder="Busca tus recetas aquí..." id="sear">
                </div>
                <div class="categoria-container">
                    <select id="categoria" name="categoria">
                        <option value="none"></option>
                        <option value="Pays">Pays</option>
                        <option value="Flanes">Flanes</option>
                        <option value="Galletas">Galletas</option>
                        <option value="Cookie cake">Cookie cake</option>
                        <option value="Cupcakes">Cupcakes</option>
                        <option value="Mostachón">Mostachón</option>
                        <option value="Cheesecake">Cheesecake</option>
                        <option value="Donut Cakes">Donut Cakes</option>
                        <option value="Profiteroles">Profiteroles</option>
                        <option value="Brownies">Brownies</option>
                        <option value="Brownies cakes">Brownies cakes</option>
                    </select>
                </div>
            </div>
            <div class="grid" id="print">
                    <!--divs de ingredientes-->
            </div>
        </div>
      </div>
    </div>

    <button id="float-btn">+</button>

    <div class="modal" id="modal">
        <div class="modal-content">
            <span class="close-btn" id="close-modal">&times;</span>
            <h2 class="modal-header" id="modal-h"></h2>
            <p>Ingredientes</p>
            <table>
                <thead>
                    <tr>
                        <th>Ingrediente</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="print-ing">
                    <!--Imprimir ingredinetes-->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Menú flotante con formulario -->
    <div id="menu" class="menu">
        <div class="menu-item">
            <h3>Agregar Receta</h3>
            <form id="add-recipe-form">
                <input type="text" id="recipe-name" placeholder="Nombre de la receta" required>
                <input type="number" id="num-porciones" placeholder="Número de porciones" required>
                <button type="submit">Agregar</button>
            </form>
        </div>
    </div>



    <script>

        document.addEventListener("DOMContentLoaded", () => filtro(""));
        let fil = document.getElementById("sear");
        fil.addEventListener("input", () => filtro(fil.value));
        function filtro(aux){
        fetch("/recetas/lista")
            .then(response => response.json())
            .then(data => {
                let container = document.getElementById("print");
                container.innerHTML = "";
                
                let i = 0;
                while (i < data.length) {
                    if (data[i].nombre.toLowerCase().includes(aux.toLowerCase())){
                        let receta = data[i]; 
                        let card = document.createElement("div"); 
                        card.classList.add("card");
                        card.innerHTML = `<h3>${receta.nombre}</h3><p>Porciones: ${receta.num_porciones}</p>`; 
                        container.appendChild(card);
                    }
                    i++; 
                }
            })
            .catch(error => console.error("Error cargando recetas:", error));
        };
    
    document.addEventListener("click", function(event) {
        if (event.target.closest(".card")) {  
            document.getElementById("modal").classList.add("active");
            document.queryseletor
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.addEventListener("click", function (event) {
            let card = event.target.closest(".card");
            if (card) {
                let nombre = card.querySelector("h3").textContent.trim();

                let modal = document.getElementById("modal");
                if (!modal) {
                console.error("No se encontró el elemento modal");
                return;
            }

            document.getElementById("modal-h").textContent = nombre;
            modal.classList.add("active");

            fetch(`/ingredientes/${encodeURIComponent(nombre)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error en la solicitud");
                    }
                    return response.json();
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        throw new Error("La respuesta no es un array válido");
                    }

                    let container = document.getElementById("print-ing");
                    if (!container) {
                        console.error("No se encontró el elemento #print-ing");
                        return;
                    }

                    container.innerHTML = "";

                    let i = 0;
                    while (i < data.length) {
                        let ingrediente = data[i];

                        let row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${ingrediente.nombre}</td>
                            <td>${ingrediente.cantidad_usada}</td>
                            <td>${ingrediente.gramaje}</td>
                            <td>
                                <span class="action-btn edit-btn">✏</span>
                                <span class="action-btn delete-btn">🗑</span>
                            </td>
                        `;
                        container.appendChild(row);
                        i++;
                    }
                })
            .catch(error => console.error("Error cargando ingredientes:", error));
        }
    });

    document.getElementById("close-modal").addEventListener("click", function () {
        document.getElementById("modal").classList.remove("active");
        });
    });
</script>
