@extends('layouts.desserts')

@section('content')
<div class="all">
    <div>
        <div class="container">
            <!-- Contenedor superior con botones y barra de búsqueda -->
            <div class="top-container">
                <div class="menu-buttons">
                    <button class="menu-btn active">Fijos</button>
                    <button class="menu-btn">Categorías</button>
                    <button class="menu-btn">Emergentes</button>
                    <button class="menu-btn">Temporada</button>
                </div>
                <!-- Barra de búsqueda y filtro -->
                <div class="cosas">
                    <div class="head">
                        <div class="search-container">
                            <input type="text" placeholder="Buscar postres..." id="searchInput" oninput="buscarPostres()">
                        </div>
                    </div> 
                </div>

                <div class="categoria-container">
                        <select id="categoria" name="categoria" onchange="filtrarPostres()">
                            <option value="">Todas las categorías</option>
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

                <!-- Grid de postres -->
                <div class="grid" id="print">
                    @foreach ($postres as $postre)
                        <div class="card" data-categoria="{{ $postre->id_categoria }}" onclick="abrirModalDetalle('{{ $postre->id_postre }}')">
                            <img src="{{ asset($postre->imagen) }}" alt="{{ $postre->nombre }}" class="w-full h-32 object-cover rounded-t-lg">
                            <h3>
                                {{ $postre->categoria ? $postre->categoria->nombre : 'Sin categoría' }} 
                                {{ $postre->nombre }}
                            </h3>
                        </div>

                        <!-- Modal de Detalles del Postre -->
                        <div class="modal" id="modalPostre{{ $postre->id_postre }}">
                            <div class="modal-content">
                                <span class="close-btn" onclick="cerrarModalDetalle('{{ $postre->id_postre }}')">&times;</span>
                                <img src="{{ asset($postre->imagen) }}" alt="{{ $postre->nombre }}" class="w-full h-40 object-cover rounded">
                                <h2 class="modal-header">{{ $postre->nombre }}</h2>
                                <p><strong>Categoría:</strong> {{ $postre->categoria ? $postre->categoria->nombre : 'Sin categoría' }}</p>
                                <p><strong>Descripción:</strong> {{ $postre->descripcion }}</p>
                                <p><strong>Stock disponible:</strong> {{ $postre->stock }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

        </div>
    </div>
</div>

<!-- Botón flotante para agregar postre -->
<button id="float-btn" onclick="abrirModalNuevoPostre()">+</button>

<!-- Modal para añadir un nuevo postre -->
<div class="modal" id="modalNuevoPostre">
    <div class="modal-content">
        <span class="close-btn" onclick="cerrarModalNuevoPostre()">&times;</span>
        <h2>Añadir Nuevo Postre</h2>
        <form action="{{ url('postres.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            
                <input type="file" name="imagen" id="imagen" placeholder="Imagen del postre"><br>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del postre"><br>
                <select name="id_categoria" id="id_categoria">
                    <option value="1">Pays</option>
                    <option value="2">Flanes</option>
                    <option value="3">Galletas</option>
                    <option value="4">Cookie cake</option>
                    <option value="5">Cupcakes</option>
                    <option value="6">Mostachon</option>
                    <option value="7">Cheesecake</option>
                    <option value="8">Donut Cakes</option>
                    <option value="9">Profiteroles</option>
                    <option value="10">Brownies</option>
                    <option value="11">Brownies cake</option>
                </select><br>    
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del postre"><br>
                <input type="text" name="atributos extra" id="atributos_extra" placeholder="Atributos extra"><br>
                <input type="text" name="paquete" id="paquete" placeholder="Paquete"><br>
                <input type="checkbox" name="requiere minimo" id="requiere_minimo" value="1"> requiere mínimo<br>
                <input type="submit" value="Agregar postre">
            
    </div>
</div>

<style>
/* Estilos generales */
.container {
    width: 90%;
    margin: auto;
    padding: 20px;
}

.head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.search-container input,
.categoria-container select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Grid de postres */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

/* Tarjetas de postres */
.card {
    background: white;
    border: 1px solid #f8c471;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
}

.card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Estilos de los modales */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    width: 50%;
}

.modal.active {
    display: block;
}

.close-btn {
    float: right;
    cursor: pointer;
    font-size: 20px;
}

/* Botón flotante */
#float-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #f8c471;
    color: white;
    border: none;
    padding: 15px;
    font-size: 20px;
    border-radius: 50%;
    cursor: pointer;
}
</style>

<style>
    .top-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .menu-buttons {
        display: flex;
        gap: 15px;
    }
    .menu-btn {
        background: none;
        border: none;
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
        color: #8a6d3b;
    }
    .menu-btn.active {
        background: #f8e5c1;
        border-radius: 10px;
        font-weight: bold;
    }
    .search-container input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 300px;
    }
    .filter-container select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    </style>

<script>
/* Abrir y cerrar modales de detalle */
function abrirModalDetalle(id) {
    let modal = document.getElementById('modalPostre' + id);
    if (modal) {
        modal.classList.add("active");
    } else {
        console.error("Modal no encontrada para el ID:", id);
    }
}

function cerrarModalDetalle(id) {
    let modal = document.getElementById('modalPostre' + id);
    if (modal) {
        modal.classList.remove("active");
    }
}

</script>

<script>
function buscarPostres() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.card').forEach(postre => {
        const nombre = postre.querySelector("h3").textContent.toLowerCase();
        postre.style.display = nombre.includes(query) ? 'block' : 'none';
    });
}
</script>

<script>
function filtrarPostres() {
    const categoriaSeleccionada = document.getElementById('categoria').value;
    document.querySelectorAll('.card').forEach(postre => {
        const categoriaPostre = postre.getAttribute("data-categoria");
        postre.style.display = (categoriaSeleccionada === "" || categoriaPostre === categoriaSeleccionada) ? 'block' : 'none';
    });
}
</script>

<script>
/* Abrir y cerrar modal de creación */
function abrirModalNuevoPostre() {
    document.getElementById('modalNuevoPostre').classList.add("active");
}
function cerrarModalNuevoPostre() {
    document.getElementById('modalNuevoPostre').classList.remove("active");
}
</script>

@endsection