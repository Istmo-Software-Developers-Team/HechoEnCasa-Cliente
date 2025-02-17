<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet"
    />

    <!-- Estilos  -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/inventario.css') }}" />

    <title>Inventario</title>
</head>
<body>
    <div class="sidebar-box">
        <!-- Notificaciones -->
        <div class="menu-icono-box">
          <svg
            class="menu-icono bx-tada-hover"
            viewBox="0 0 64 64"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M24.889 53.5757C26.7761 55.0833 29.2682 56 32.0001 56C34.732 56 37.2241 55.0833 39.1112 53.5757M12.0204 45.8181C10.8961 45.8181 10.2682 44.0519 10.9483 43.0705C12.5264 40.7934 14.0496 37.4537 14.0496 33.432L14.1146 27.6044C14.1146 16.7772 22.1222 8 32.0001 8C42.0234 8 50.149 16.9065 50.149 27.8932L50.0839 33.432C50.0839 37.4813 51.5545 40.8393 53.0685 43.1173C53.7222 44.1011 53.0927 45.8181 51.9823 45.8181H12.0204Z"
            />
          </svg>
        </div>
        <!-- Menu -->
        <nav class="sidebar-menu">
          <ul>
            <!-- Inicio -->
            <a href="{{ url('/') }}">
              <li class="menu-seccion">
                <div class="menu-icono-box ">
                  <svg
                    class="menu-icono"
                    viewBox="0 0 60 60"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M8.5 23.5401C8.5 22.9621 8.7939 22.4003 9.32162 22.0434L28.8216 8.85629C29.5241 8.38124 30.4759 8.38124 31.1784 8.85629L50.6784 22.0434C51.2061 22.4003 51.5 22.9621 51.5 23.5401V48.2205C51.5 49.985 49.9809 51.5 48 51.5H12C10.0191 51.5 8.5 49.985 8.5 48.2205V23.5401Z"
                    />
                  </svg>
                </div>
                <span>Inicio</span>
              </li>
            </a>
            <!-- Calendario -->
            <a href="{{ route('ingredientes.index') }}">
              <li class="menu-seccion">
                <div class="menu-icono-box">
                  <svg
                    class="menu-icono"
                    viewBox="0 0 60 60"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M18.3265 19.0362H43.6234M17.1862 5.00025V9.57924M17.1862 9.57924L43.7479 9.57875M17.1862 9.57924C12.7851 9.57924 9.21782 13.2083 9.21803 17.6855L9.21926 44.7065C9.21947 49.1834 12.787 52.8125 17.1878 52.8125H43.7495C48.1505 52.8125 51.7182 49.1829 51.718 44.7058L51.7168 17.6847C51.7166 13.2079 48.1487 9.57875 43.7479 9.57875M43.7479 5V9.57875M25.1567 43.3551V27.1424L19.8443 31.1955M39.7656 43.3551V27.1424L34.4533 31.1955"
                    />
                  </svg>
                </div>
                <span>Calendario</span>
              </li>
            </a>
            <!-- Recetas -->
            <a href="{{ route('ingredientes.index') }}">
              <li class="menu-seccion">
                <div class="menu-icono-box">
                  <svg
                    class="menu-icono"
                    viewBox="0 0 60 60"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M19.5 19.5H40.5M19.5 31.5H40.5M14.4 7.5H45.6C47.7539 7.5 49.5 9.51472 49.5 12V52.5L43 48L36.5 52.5L30 48L23.5 52.5L17 48L10.5 52.5V12C10.5 9.51472 12.2461 7.5 14.4 7.5Z"
                    />
                  </svg>
                </div>
                <span>Recetas</span>
              </li>
            </a>
            <!-- Inventario -->
            <a href="{{ route('ingredientes.index') }}">
              <li class="menu-seccion">
                <div class="menu-icono-box activo">
                  <svg
                    class="menu-icono"
                    viewBox="0 0 60 60"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M51.0998 19.375H8.90015M36.25 28.75C31.0633 28.75 23.75 28.75 23.75 28.75M51.25 20.6291V45.9375C51.25 48.8715 48.8715 51.25 45.9375 51.25H14.0625C11.1285 51.25 8.75 48.8715 8.75 45.9375V20.6291C8.75 19.8044 8.94202 18.991 9.31086 18.2533L12.9612 10.9525C13.6362 9.60266 15.0158 8.75 16.525 8.75H43.475C44.9842 8.75 46.3638 9.60267 47.0388 10.9525L50.6891 18.2533C51.058 18.991 51.25 19.8044 51.25 20.6291Z"
                    />
                  </svg>
                </div>
                <span>Inventario</span>
              </li>
            </a>
            <!-- Postres -->
            <a href="{{ route('ingredientes.index') }}">
              <li class="menu-seccion">
                <div class="menu-icono-box">
                  <svg
                    class="menu-icono"
                    viewBox="0 0 60 60"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M30.4364 54.3005V19.3914M26.3739 17.2972C26.8061 17.3942 27.2615 17.2753 27.5726 16.9642C27.8838 16.653 28.0025 16.1975 27.9057 15.7655C27.5178 14.181 26.0889 8.87539 24.6218 7.40823C22.7939 5.58033 19.8189 5.57271 18 7.39157C16.1813 9.2103 16.1886 12.1853 18.0167 14.0133C19.5078 15.5045 24.7895 16.9094 26.3739 17.2972ZM30.8103 15.7653C30.7133 16.1975 30.8322 16.6529 31.1434 16.9641C31.4545 17.2752 31.9101 17.3939 32.3421 17.2971C33.9265 16.9092 39.2321 15.4804 40.6993 14.0132C42.5272 12.1853 42.5348 9.21031 40.716 7.39145C38.8972 5.57272 35.9222 5.58007 34.0942 7.4081C32.603 8.89928 31.1982 14.1809 30.8103 15.7653ZM7.74546 31.6096H52.2545C53.2185 31.6096 54 30.8282 54 29.8642V21.1369C54 20.1729 53.2185 19.3914 52.2545 19.3914H7.74545C6.78147 19.3914 6 20.1729 6 21.1369V29.8642C6 30.8282 6.78147 31.6096 7.74546 31.6096ZM49.6364 31.6096V52.5551C49.6364 53.5191 48.8549 54.3005 47.8909 54.3005H12.1091C11.1451 54.3005 10.3636 53.5191 10.3636 52.5551V31.6096H49.6364Z"
                    />
                  </svg>
                </div>
                <span>Postres</span>
              </li>
            </a>
          </ul>
        </nav>
      </div>

    @extends('layouts.app')

    @section('content')
      {{-- Aqui ya empieza lo bueno --}}
      <div class="main-box">
    
        <!-- Filtros -->

      
        <!-- Botón para añadir un nuevo ingrediente -->
        <button class="boton-agregar" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
            <i class='bx bx-plus-circle bx-sm bx-tada-hover'></i>
        </button>

        <div class="caja-filtrar-buscar">
            <div class="caja-buscar">
                <input 
                    type="text" 
                    id="searchInput" 
                    class="" 
                    placeholder="Buscar ingredientes..." 
                    oninput="searchIngredients()" 
                />
            </div>
      
              <form action="{{ route('ingredientes.index') }}" method="GET" class="d-flex">
                  <select name="filter" class="form-select" onchange="this.form.submit()">
                      <option value="">Todas los ingredientes</option> <!-- Opción para eliminar los filtros -->
                      <option value="agotados" {{ request('filter') == 'agotados' ? 'selected' : '' }}>Agotados</option>
                      <option value="casi_agotados" {{ request('filter') == 'casi_agotados' ? 'selected' : '' }}>Casi Agotados</option>
                      <option value="gramos" {{ request('filter') == 'gramos' ? 'selected' : '' }}>Gramos</option>
                      <option value="mililitros" {{ request('filter') == 'mililitros' ? 'selected' : '' }}>Mililitros</option>
                      <option value="piezas" {{ request('filter') == 'piezas' ? 'selected' : '' }}>Piezas</option>
                  </select>
              </form>
        </div>


        
    
        <!-- Lista de Ingredientes -->
        <div class="contenedor-elementos">
            @forelse($ingredientes as $ingrediente)
            <div 
            class="caja-elemento 
                @if($ingrediente->stock == 0) agotado 
                @elseif($ingrediente->stock <= 5) casi-agotado 
                @endif"
            onclick="abrirModal('{{ $ingrediente->id_ing }}')"
        >
            <div class="color-header"></div>
    
            <!-- Detalles del ingrediente -->
            <div class="nombre-acciones">
                <h2 class="nombre-elemento">{{ $ingrediente->nombre }}</h2>
                <form action="{{ route('ingredientes.destroy', $ingrediente->id_ing) }}" method="POST" class="boton-borrar" onclick="event.stopPropagation();">
                    @csrf
                    @method('DELETE')
                    <div class="eliminar-accion">
                        <button 
                            type="button" 
                            title="Eliminar" 
                            onclick="showDeleteModal('{{ $ingrediente->id_ing }}')"
                        >
                            <i class="bx bx-trash bx-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
    
            <p class="cantidad-detalle">{{ $ingrediente->stock }} {{ $ingrediente->unidad->abreviacion ?? 'Unidad no asignada' }}</p>
        </div>
        
                <!-- Modal para ver detalles y actualizar stock -->
                <div class="modal fade" id="modalIngrediente{{ $ingrediente->id_ing }}" tabindex="-1" aria-labelledby="modalLabel{{ $ingrediente->id_ing }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $ingrediente->id_ing }}">{{ $ingrediente->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Disponible:</strong> <span id="stock-display-{{ $ingrediente->id_ing }}">{{ $ingrediente->stock }}</span> {{ $ingrediente->unidad->abreviacion ?? 'Unidad no asignada' }}</p>
                                <p><strong>Máximo:</strong> {{ $ingrediente->cantidad_total }} {{ $ingrediente->unidad->abreviacion ?? 'Unidad no asignada' }}</p>
        
                                <!-- Barra de progreso -->
                                <div class="progress">
                                    <div 
                                        class="progress-bar bg-success" 
                                        role="progressbar" 
                                        style="width: {{ ($ingrediente->stock / $ingrediente->cantidad_total) * 100 }}%;"
                                        aria-valuenow="{{ $ingrediente->stock }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="{{ $ingrediente->cantidad_total }}">
                                    </div>
                                </div>
        
                                <!-- Botones de incrementar/decrementar -->
                                <div class="input-group mt-3">
                                    <button type="button" class="btn btn-danger" onclick="updateStock('{{ $ingrediente->id_ing }}', -getInputValue('{{ $ingrediente->id_ing }}'))">-</button>
                                    <input type="number" id="cantidad-{{ $ingrediente->id_ing }}" value="100" class="form-control text-center" min="1">
                                    <button type="button" class="btn btn-success" onclick="updateStock('{{ $ingrediente->id_ing }}', getInputValue('{{ $ingrediente->id_ing }}'))">+</button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No hay ingredientes que coincidan con el filtro seleccionado.
                    </div>
                </div>
            @endforelse
        </div>
    
        <!-- Modal para añadir un nuevo ingrediente -->
        <div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('ingredientes.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addIngredientLabel">Añadir Nuevo Ingrediente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Ingrediente</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
    
                            <!-- Cantidad disponible (stock) -->
                            <div class="mb-3">
                                <label for="stock" class="form-label">Cantidad Disponible</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
    
                            <!-- Unidad -->
                            <div class="mb-3">
                                <label for="id_unidad" class="form-label">Unidad</label>
                                <select class="form-select" id="id_unidad" name="id_unidad" required>
                                    <option value="" disabled selected>Selecciona una unidad</option>
                                    @foreach($unidades as $unidad)
                                        <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre_unidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    @endsection

    
</body>
<!-- Modal de Confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">¿Estás seguro?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
              <p>¿Seguro que deseas eliminar este ingrediente?</p>
          </div>
          <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <form id="confirmDeleteForm" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Eliminar</button>
              </form>
          </div>
      </div>
  </div>
</div>

</html>

<!-- JavaScript para manejar los botones "más" y "menos" -->
<script>
    function showDeleteModal(id) {
        // Configurar el formulario para eliminar el ingrediente con el ID proporcionado
        const deleteForm = document.getElementById('confirmDeleteForm');
        deleteForm.action = `/ingredientes/${id}`; // Ruta dinámica según el ID del ingrediente

        // Mostrar el modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
    function searchIngredients() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const ingredientes = document.querySelectorAll('.caja-elemento');

        ingredientes.forEach(ingrediente => {
            const nombre = ingrediente.querySelector('.nombre-elemento').textContent.toLowerCase();
            if (nombre.includes(query)) {
                ingrediente.style.display = 'block';
            } else {
                ingrediente.style.display = 'none';
            }
        });
    }
    function getInputValue(id) {
        const input = document.getElementById(`cantidad-${id}`);
        const value = parseInt(input.value, 10);
        return isNaN(value) ? 0 : value; // Asegurarse de que el valor sea un número válido
    }

    function abrirModal(id) {
        const modal = new bootstrap.Modal(document.getElementById('modalIngrediente' + id));
        modal.show();
    }

    function updateStock(ingredienteId, cantidad) {
        fetch(`/ingredientes/${ingredienteId}/update-stock`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cantidad: cantidad })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar el valor del stock en la interfaz
                document.getElementById(`stock-display-${ingredienteId}`).textContent = data.newStock;

                // Actualizar la barra de progreso
                const progressBar = document.querySelector(`#modalIngrediente${ingredienteId} .progress-bar`);
                progressBar.style.width = `${(data.newStock / data.maxStock) * 100}%`;
                progressBar.setAttribute('aria-valuenow', data.newStock);
            } else {
                alert(data.error || 'Ocurrió un error al actualizar el stock.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al intentar actualizar el stock.');
        });
    }
</script>
