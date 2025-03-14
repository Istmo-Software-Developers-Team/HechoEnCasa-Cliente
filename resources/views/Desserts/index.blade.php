@extends('layouts.desserts')

@section('content')
<div class="all">
    <div>
        <div class="container">
            <!-- Contenedor superior con botones y barra de búsqueda -->
            <div class="top-container">
                <div class="menu-buttons">
                    <button class="menu-btn active" onclick="window.location.href='{{ route('postres.index') }}'">
                        Fijos
                    </button>
                    <button class="menu-btn" onclick="window.location.href='{{ route('categorias.index') }}'">
                        Categorías
                    </button>
                    <button class="menu-btn" onclick="window.location.href='{{ route('emergentes.index') }}'">
                        Emergentes
                    </button>
                    <button class="menu-btn " onclick="window.location.href='{{ route('temporada.index') }}'">
                        Temporada
                    </button>
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
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_cat }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    
                    </div>
                </div>

                <!-- Grid de postres -->
                <div class="grid" id="print">
                    @foreach ($postres as $postre)
                        <div class="card" data-categoria="{{ $postre->id_categoria }}" onclick="abrirModalDetalle('{{ $postre->id_postre }}')">
                            <img src="{{ asset($postre->imagen) }}" alt="{{ $postre->nombre }}" class="w-full h-32 object-cover rounded-t-lg">
                            <h3>
                                {{ $postre->categoria ? $postre->categoria->nombre : '' }} 
                                {{ $postre->nombre }}
                            </h3>
                        </div>

                        <!-- Modal de Detalles del Postre -->
                        <div class="modal" id="modalPostre{{ $postre->id_postre }}">
                            <div class="modal-content">
                                <span class="close-btn" onclick="cerrarModalDetalle('{{ $postre->id_postre }}')">&times;</span>

                                <!-- Contenedor de la imagen con botón de edición -->
                                <div class="image-container">
                                    <img src="{{ asset($postre->imagen) }}" alt="{{ $postre->nombre }}" class="postre-img">
                                    
                                    <!-- Botón para cambiar la imagen -->
                                    <button class="edit-image-btn" onclick="abrirEditarImagen('{{ $postre->id_postre }}')">
                                        🖊
                                    </button>
                                </div>
                                
                                <h2 class="modal-header">{{ $postre->nombre }}</h2>
                                <p><strong>Categoría:</strong> {{ $postre->categoria ? $postre->categoria->nombre : 'Sin categoría' }}</p>
                                <p><strong>Descripción:</strong> {{ $postre->descripcion }}</p>
                                <p><strong>Atributos extra:</strong> 
                                    @foreach($postre->atributosExtra as $atributo)
                                        {{ $atributo->nom_atributo }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>

                                <div class="paquetes-container">
                                    <label for="unidadSeleccionada"><strong>Paquetes</strong></label>
                                    <select id="unidadSeleccionada-{{ $postre->id_postre }}" class="unidad-seleccionada" onchange="actualizarPaquetes('{{ $postre->id_postre }}')">
                                        @foreach($postre->unidadesMedida as $unidad)
                                            <option value="{{ $unidad->id_um }}">{{ $unidad->nombre_unidad }}</option>
                                        @endforeach
                                    </select>
                                
                                    <div id="paquetes-{{ $postre->id_postre }}" class="paquetes-info">
                                        @foreach($postre->unidadesMedida->unique('cantidad') as $unidad)
                                        <div class="paquete" data-unidad="{{ $unidad->id_um }}">
                                            <button class="paquete-btn">{{ $unidad->cantidad }}</button>
                                        </div>
                                    @endforeach
                                    
                                    </div>
                                </div>
                                
                                
                                
                                <p><strong>Requiere mínimo:</strong> <input type="checkbox" id="modal-checkbox-minimo-{{ $postre->id_postre }}" onclick="toggleMinimo('{{ $postre->id_postre }}')" {{ $postre->requiere_minimo ? 'checked' : '' }}></p>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </div>
    </div>
</div>

<!-- Botón flotante para agregar postre -->
<button id="float-btn" onclick="abrirModalNuevoPostre()">+</button>

<!-- Modal para editar imagen del postre -->
<div class="modal" id="modalEditarImagen">
    <div class="modal-content">
        <span class="close-btn" onclick="cerrarEditarImagen('{{ $postre->id_postre }}')">&times;</span>
        <h2>Editar Imagen del Postre</h2>
        <form action="{{ route('postres.updateImagen') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_postre" id="editarImagenId">
            
            <label>Nueva Imagen:</label>
            <input type="file" name="imagen" required><br>
            
            <input type="submit" value="Actualizar Imagen">
        </form>
    </div>
</div>


<!-- Modal para añadir un nuevo postre -->
<div class="modal" id="modalNuevoPostre">
    <div class="modal-content">
        <span class="close-btn" onclick="cerrarModalNuevoPostre('{{ $postre->id_postre }}')">&times;</span>
        <h2>Añadir Nuevo Postre</h2>
        <form action="{{ route('postres.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <label></label>
            <input type="file" name="imagen" id="imagen"><br>

            <label></label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del postre" required><br>

            <label>Categoría:</label>
            <select name="id_categoria" id="id_categoria" required>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id_cat }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select><br>

            <label>Recetas:</label>
            <select name="id_receta[]" id="id_receta" multiple  required>
                @foreach ($recetas as $receta)
                    <option value="{{ $receta->id_receta }}">{{ $receta->nombre }}</option>
                @endforeach
            </select><br>
            
            <label>Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del postre" required><br>

            <label>Atributos extra:</label>
            <select name="atributos_extra[]" id="atributos_extra">
                @foreach($atributosExtras as $atributo)
                    <option value="{{ $atributo->id_atributo }}">{{ $atributo->nom_atributo }}</option>
                @endforeach
            </select><br>
            

            <label>Paquete:</label>
            <input type="text" name="paquete" id="paquete" placeholder="Paquete"><br>

            <label>Stock:</label>
            <input type="number" name="stock" id="stock" placeholder="Cantidad disponible" required><br>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio_emergentes" id="precio" placeholder="Precio del postre" required><br>

            <label>Requiere mínimo:</label>
            <input type="checkbox" name="requiere_minimo" id="requiere_minimo" value="1"><br>

            <input type="submit" value="Agregar postre">
        </form>
    </div>
</div>


<style>
.image-container {
    position: relative;
    display: inline-block;
}

.postre-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

.edit-image-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.8);
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 18px;
    transition: 0.3s;
}

.edit-image-btn:hover {
    background: rgba(255, 255, 255, 1);
}

</style>

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
    function abrirEditarImagen(id) {
        document.getElementById('editarImagenId').value = id;
        document.getElementById('modalEditarImagen').classList.add("active");
    }
    
    function cerrarEditarImagen() {
        document.getElementById('modalEditarImagen').classList.remove("active");
    }
    </script>
    

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
    /* Abrir y cerrar modal de creación */
    function abrirModalNuevoPostre() {
        document.getElementById('modalNuevoPostre').classList.add("active");
    }
    function cerrarModalNuevoPostre() {
        document.getElementById('modalNuevoPostre').classList.remove("active");
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
    function toggleMinimo(id) {
        const checkbox = document.getElementById('checkbox-minimo-' + id);
        const infoDiv = document.getElementById('paquete-info-' + id);
        
        if (checkbox.checked) {
            infoDiv.innerHTML = `<p><strong>Mínimo:</strong> {{ $postre->minimo }} piezas</p>`;
        } else {
            infoDiv.innerHTML = `<p><strong>Paquetes:</strong> {{ $postre->paquete }}</p>`;
        }
    }
</script>

<script>
function actualizarPaquetes(postreId) {
    const unidadSeleccionada = document.getElementById(`unidadSeleccionada-${postreId}`).value;
    const paquetesContainer = document.getElementById(`paquetes-${postreId}`);

    // Ocultar todos los paquetes de este postre
    paquetesContainer.querySelectorAll(`.paquete[data-postre="${postreId}"]`).forEach(paquete => {
        paquete.style.display = 'none';
    });

    // Mostrar solo los paquetes de la unidad seleccionada
    paquetesContainer.querySelectorAll(`.paquete[data-unidad="${unidadSeleccionada}"]`).forEach(paquete => {
        paquete.style.display = 'block';
    });
}
</script>

@endsection