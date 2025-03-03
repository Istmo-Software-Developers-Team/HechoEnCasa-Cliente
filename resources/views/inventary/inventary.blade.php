<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Ingredientes</title>
  <!-- Enlaces a CSS y JS -->
</head>
<body>
  <div class="main-box">
    
    <!-- Sección de Filtros y Búsqueda -->
    <div class="caja-filtrar-buscar">
      <div class="caja-buscar">
        <input type="text" id="searchInput" placeholder="Buscar ingredientes..." oninput="searchIngredients()">
      </div>
      <form action="{{ route('ingredientes.index') }}" method="GET" class="d-flex">
        <select name="filter" class="form-select" onchange="this.form.submit()">
          <option value="">Todas los ingredientes</option>
          <option value="agotados" {{ request('filter') == 'agotados' ? 'selected' : '' }}>Agotados</option>
          <option value="casi_agotados" {{ request('filter') == 'casi_agotados' ? 'selected' : '' }}>Casi Agotados</option>
          <option value="gramos" {{ request('filter') == 'gramos' ? 'selected' : '' }}>Gramos</option>
          <option value="mililitros" {{ request('filter') == 'mililitros' ? 'selected' : '' }}>Mililitros</option>
          <option value="piezas" {{ request('filter') == 'piezas' ? 'selected' : '' }}>Piezas</option>
        </select>
      </form>
    </div>

    <!-- Botón para añadir un nuevo ingrediente -->
    <button class="boton-agregar" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
      <i class='bx bx-plus-circle bx-sm bx-tada-hover'></i>
    </button>

    <!-- Lista de Ingredientes -->
    <div class="contenedor-elementos">
      @forelse($ingredientes as $ingrediente)
      <div class="caja-elemento @if($ingrediente->stock == 0) agotado @elseif($ingrediente->stock <= 5) casi-agotado @endif" onclick="abrirModal('{{ $ingrediente->id_ing }}')">
        <div class="color-header"></div>
        <div class="nombre-acciones">
          <h2 class="nombre-elemento">{{ $ingrediente->nombre }}</h2>
          <form action="{{ route('ingredientes.destroy', $ingrediente->id_ing) }}" method="POST" class="boton-borrar" onclick="event.stopPropagation();">
            @csrf
            @method('DELETE')
            <div class="eliminar-accion">
              <button type="button" title="Eliminar" onclick="showDeleteModal('{{ $ingrediente->id_ing }}')">
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
            <div class="d-flex align-items-center">
              <h5 class="modal-title" id="modalLabel{{ $ingrediente->id_ing }}">
                <span id="nombre-ingrediente-{{ $ingrediente->id_ing }}">{{ $ingrediente->nombre }}</span>
                <i class="bi bi-pencil-square ms-2" onclick="enableEdit('{{ $ingrediente->id_ing }}')" style="cursor: pointer;"></i>
              </h5>
            </div>
            <div class="modal-body">
              <p><strong>Disponible:</strong> <span id="stock-display-{{ $ingrediente->id_ing }}">{{ $ingrediente->stock }}</span> {{ $ingrediente->unidad->abreviacion ?? 'Unidad no asignada' }}</p>
              <p><strong>Máximo:</strong> {{ $ingrediente->cantidad_total }} {{ $ingrediente->unidad->abreviacion ?? 'Unidad no asignada' }}</p>
              <div id="edit-container-{{ $ingrediente->id_ing }}" class="d-none mt-2">
                <input type="text" id="edit-nombre-{{ $ingrediente->id_ing }}" class="form-control" value="{{ $ingrediente->nombre }}">
                <button class="btn btn-primary mt-2" onclick="changeIngredientName('{{ $ingrediente->id_ing }}')">Guardar</button>
              </div>
              <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($ingrediente->stock / $ingrediente->cantidad_total) * 100 }}%;" aria-valuenow="{{ $ingrediente->stock }}" aria-valuemin="0" aria-valuemax="{{ $ingrediente->cantidad_total }}"></div>
              </div>
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
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Ingrediente</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="mb-3">
                <label for="stock" class="form-label">Cantidad Disponible</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
              </div>
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

  <!-- JavaScript -->
  <script>
    function showDeleteModal(id) {
      const deleteForm = document.getElementById('confirmDeleteForm');
      deleteForm.action = `/ingredientes/${id}`;
      const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
      deleteModal.show();
    }

    function searchIngredients() {
      const query = document.getElementById('searchInput').value.toLowerCase();
      const ingredientes = document.querySelectorAll('.caja-elemento');
      ingredientes.forEach(ingrediente => {
        const nombre = ingrediente.querySelector('.nombre-elemento').textContent.toLowerCase();
        ingrediente.style.display = nombre.includes(query) ? 'block' : 'none';
      });
    }

    function getInputValue(id) {
      const input = document.getElementById(`cantidad-${id}`);
      const value = parseInt(input.value, 10);
      return isNaN(value) ? 0 : value;
    }

    function abrirModal(id) {
      const modal = new bootstrap.Modal(document.getElementById('modalIngrediente' + id));
      modal.show();
    }

    function enableEdit(ingredienteId) {
      document.getElementById(`nombre-ingrediente-${ingredienteId}`).classList.add('d-none');
      document.getElementById(`edit-container-${ingredienteId}`).classList.remove('d-none');
    }
  </script>
</body>
</html>