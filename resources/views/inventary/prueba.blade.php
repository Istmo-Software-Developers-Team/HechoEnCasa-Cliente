<!-- Modal para ver detalles y actualizar stock -->
<div class="modal fade" id="modalIngrediente{{ $ingrediente->id_ing }}" tabindex="-1" aria-labelledby="modalLabel{{ $ingrediente->id_ing }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $ingrediente->id_ing }}">
                    {{ $ingrediente->nombre }}
                    <!-- Ícono de lápiz para editar el nombre -->
                    <i class="bi bi-pencil-square ms-2" style="cursor: pointer;" onclick="openEditNameModal({{ $ingrediente->id_ing }}, '{{ $ingrediente->nombre }}')"></i>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Disponible:</strong> <span id="stock-display-{{ $ingrediente->id_ing }}">{{ $ingrediente->stock }}</span> {{ $ingrediente->unidad->abreviacion ?? 'Unidad no asignada' }}</p>
                <p><strong>Máximo:</strong> {{ $ingrediente->cantidad_total }} {{ $ingrediente->unidad->abreviacion ?? 'Unidad no asignada' }}</p>
            </div>
        </div>
    </div>
</div>