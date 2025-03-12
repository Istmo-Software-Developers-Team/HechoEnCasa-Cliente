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
            <div id="modal-name">
                <h2 class="modal-header" id="modal-h"></h2>
                
            </div>
            <div id="modal-por"></div>
            <div class="op-recipe">
                <div class="delete-recipe">🗑</div>
                <div class="add-recipe">✔</div>
            </div>
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
            <div>
                <BUtton id="add-btn">+</BUtton>
            </div>
        </div>
    </div>

    <script>
    let nom_receta ="";
    

    //Mostrar recetas
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
    
    //Mostra menu info recetas
    document.addEventListener("click", function(event) {
        if (event.target.closest(".card")) {  
            document.getElementById("modal").classList.add("active");
        }
    });

    //Mostra ingredientes de una receta en el menu info recetas
    document.addEventListener("DOMContentLoaded", function () {
        showIng();


    //Cerrar menu info recetas
    document.getElementById("close-modal").addEventListener("click", function () {
        document.getElementById("modal").classList.remove("active");
        });
    });

    function showIng(){
        document.addEventListener("click", function (event) {
            let card = event.target.closest(".card");
            if (card) {
                let nombre = card.querySelector("h3").textContent.trim();
                let porci = card.querySelector("p").textContent.trim();

                let modal = document.getElementById("modal");
                if (!modal) {
                console.error("No se encontró el elemento modal");
                return;
            }
            nom_receta = nombre;
            document.getElementById("modal-h").textContent = nombre;
            document.getElementById("modal-por").innerHTML = `<p>${porci}</p>`
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
                            <td class="tbnom">${ingrediente.nombre}</td>
                            <td class="tbcan">${ingrediente.cantidad_usada}</td>
                            <td class="tbgra">${ingrediente.gramaje}</td>
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
    }

    //Agregar receta a la BD
    document.querySelector(".add-recipe").addEventListener("click", function(event) {
        event.preventDefault(); 

        let num = document.getElementById("num-porciones").value;
        let nom = document.getElementById("recipe-name").value;

        if (nom.trim() === "" || num.trim() === "") {
            alert("Por favor, completa todos los campos.");
            return;
        }

        fetch("/nuevo", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({
                nombre: nom,
                num_porciones: num
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            //alert("Receta agregada con éxito");

            document.getElementById("num-porciones").value = "";
            document.getElementById("recipe-name").value = "";

            document.getElementById("modal").classList.remove("active");
            filtro(fil.value)
        })
        .catch(error => console.error("Error al agregar receta:", error));

    });

    //Eliminar receta de la BD
    document.querySelector(".delete-recipe").addEventListener("click", function() {
        let nom = document.getElementById("modal-h").innerHTML;

        fetch('/eliminar', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nombre: nom
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            //alert("Receta eliminada con éxito");
            filtro(fil.value)
            document.getElementById("modal").classList.remove("active");
        })
        .catch(error => console.error("Error al eliminar receta:", error));
    });

    //Mostra menu add recetas
    document.getElementById("float-btn").addEventListener("click", function() {
        document.getElementById("modal").classList.add("active");
        document.getElementById("modal-h").innerHTML= `<input type="text" placeholder="Nombre de la receta" id="recipe-name">`;
        document.getElementById("modal-por").innerHTML= `<input type="text" placeholder="Numero de porciones" id="num-porciones">`;
        document.getElementById("print-ing").innerHTML = "";
    });

    document.getElementById("add-btn").addEventListener("click", function(){
        let row = document.createElement("tr");
        if (!document.querySelector(".selec-ing")) {
            row.innerHTML = `
                <td><select name="ing" class="selec-ing" id="slig"></select></td>
                <td><input type="number" class="num-tb"></td>
                <td><select name="uni" class="selec-ing" id="slun"></td>
                <td>
                    <span class="action-btn save-btn" id="save-btn">✔</span>
                </td>
            `;
        }
        document.getElementById("print-ing").appendChild(row);
        fetch("/Ing")
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la solicitud");
            }
            return response.json();
        })
        .then(data => {
            let ingr = document.getElementById("slig");
            ingr.innerHTML = ''; 

            data.forEach(ingrediente => {
                let option = document.createElement("option");
                option.value = ingrediente.id_ing;
                option.textContent = ingrediente.nombre;
                ingr.appendChild(option);
            });
        })
        .catch(error => console.error("Error:", error));

        fetch("/Uni")
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la solicitud");
            }
            return response.json();
        })
        .then(data => {
            let uni = document.getElementById("slun");
            uni.innerHTML = ''; 

            data.forEach(unidad => {
                let option = document.createElement("option");
                option.value = unidad.id_unidad;
                option.textContent = unidad.nombre_unidad;
                uni.appendChild(option);
            });
        })
        .catch(error => console.error("Error:", error));

        document.getElementById("save-btn").addEventListener("click", function(){
            let ig = document.getElementById("slig");
            let un = document.getElementById("slun");
            let num = document.querySelector(".num-tb")
            let ga = un.options[un.selectedIndex].textContent;

            if(ig.value && un.value && num.value){
                fetch("/nuevoIng", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        id_receta: 1,
                        id_ing: ig.value,
                        gramaje: ga,
                        cantidad_usada: num.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    showIng();
                })
                .catch(error => console.error("Error al agregar receta:", error));
            }else{
                alert("todos los campos deben esta completados");
            }
        });

        document.getElementById("print-ing").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn")) {
        let row = event.target.closest("tr");

        let cant = row.querySelector(".tbcan").textContent;
        let gram = row.querySelector(".tbgra").textContent;

        console.log(cant + "\n" + gram);

        fetch('/eliminarIng', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                cantidad_usada: cant,
                gramaje: gram
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            showIng();
        })
        .catch(error => console.error("Error al eliminar receta:", error));
    }
});

        
    });
    
</script>
