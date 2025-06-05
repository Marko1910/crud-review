@extends('layouts.app') {{-- Extiende el layout principal --}}

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-10 max-w-xl mx-auto my-12 transform transition duration-300 hover:scale-100"> {{-- Tamaño más sutil (max-w-xl) y más padding (p-10), margen vertical (my-12) y transición --}}
    <h1 class="text-3xl font-extrabold text-gray-900 text-center mb-8">Crear Nueva Reseña</h1> {{-- Título ligeramente más pequeño --}}

    <form action="{{ route('reseñas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Protección CSRF de Laravel --}}

        <!-- Sección de Información de la Reseña -->
        <div class="mb-8 border-b pb-6 border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Detalles de la Reseña</h2>

            <!-- Campo Comentario -->
            <div class="mb-6"> {{-- Ajuste de mb --}}
                <label for="comentario" class="block text-gray-700 text-sm font-semibold mb-2">Comentario:</label>
                <textarea name="comentario" id="comentario" rows="4" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out placeholder-gray-500" placeholder="Escribe tu comentario aquí..." required>{{ old('comentario') }}</textarea> {{-- Ajustes de py, px y placeholder --}}
                @error('comentario')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Calificación con Estrellas -->
            <div class="mb-6"> {{-- Ajuste de mb --}}
                <label for="calificacion_stars" class="block text-gray-700 text-sm font-semibold mb-2">Calificación:</label>
                <div id="calificacion_stars" class="flex items-center space-x-0.5 text-3xl cursor-pointer"> {{-- Estrellas más grandes y menos espacio entre ellas --}}
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="far fa-star text-gray-400 hover:text-yellow-500 transition-colors duration-200" data-rating="{{ $i }}"></i> {{-- Transición de color --}}
                    @endfor
                </div>
                <input type="hidden" name="calificacion" id="calificacion_hidden" value="{{ old('calificacion', 0) }}" required>
                @error('calificacion')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Imagen con Vista Previa -->
            <div class="mb-6">
                <label for="imagen" class="block text-gray-700 text-sm font-semibold mb-2">Imagen de la Reseña:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 transition duration-200 ease-in-out" onchange="previewImage(event)"> {{-- Color de archivo input más claro --}}
                <p class="text-gray-500 text-xs mt-2">Sube una imagen relacionada con tu reseña (opcional).</p>
                @error('imagen')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                
                {{-- Contenedor para la vista previa de la imagen --}}
                <div class="mt-4 flex justify-center p-2 border border-gray-200 rounded-lg bg-gray-50"> {{-- Contenedor de preview con borde y fondo --}}
                    <img id="imagePreview" src="https://placehold.co/180x180/e2e8f0/64748b?text=Preview" alt="Vista previa de la imagen" class="w-44 h-44 object-cover rounded-md shadow-inner border border-gray-300"> {{-- Imagen más pequeña --}}
                </div>
            </div>
        </div>

        <!-- Sección de Asociación de Producto -->
        <div class="mb-8 pb-6"> {{-- Removido border-b para el último div para un look más limpio --}}
            <h2 class="text-xl font-bold text-gray-800 mb-6">Asociar a Producto</h2>
            <!-- Campo Producto ID (relación) -->
            <div class="mb-5">
                <label for="producto_id" class="block text-gray-700 text-sm font-semibold mb-2">Producto:</label>
                <select name="producto_id" id="producto_id" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out" required> {{-- Ajustes de py, px --}}
                    <option value="">Selecciona un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('producto_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end mt-6 space-x-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                <i class="fas fa-save mr-2"></i> Guardar Reseña
            </button>
            <a href="{{ route('reseñas.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2.5 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                <i class="fas fa-times-circle mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Función para la vista previa de la imagen
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            document.getElementById('imagePreview').src = "https://placehold.co/180x180/e2e8f0/64748b?text=Preview"; // Tamaño de placeholder ajustado
        }
    }

    // Lógica para la calificación con estrellas
    document.addEventListener('DOMContentLoaded', function() {
        const starsContainer = document.getElementById('calificacion_stars');
        const hiddenInput = document.getElementById('calificacion_hidden');
        const stars = starsContainer.querySelectorAll('i');

        // Función para actualizar el estado visual de las estrellas
        function updateStars(rating) {
            stars.forEach(star => {
                const starRating = parseInt(star.dataset.rating);
                if (starRating <= rating) {
                    star.classList.remove('far', 'text-gray-400');
                    star.classList.add('fas', 'text-yellow-500');
                } else {
                    star.classList.remove('fas', 'text-yellow-500');
                    star.classList.add('far', 'text-gray-400');
                }
            });
        }

        // Cargar calificación inicial si existe (para old('calificacion'))
        const initialRating = parseInt(hiddenInput.value);
        if (initialRating > 0) {
            updateStars(initialRating);
        }

        // Evento hover para visualización antes de hacer clic
        starsContainer.addEventListener('mouseover', function(e) {
            if (e.target.tagName === 'I') {
                const hoverRating = parseInt(e.target.dataset.rating);
                updateStars(hoverRating);
            }
        });

        // Evento mouseout para volver a la calificación seleccionada o a cero
        starsContainer.addEventListener('mouseout', function() {
            updateStars(parseInt(hiddenInput.value));
        });

        // Evento click para establecer la calificación
        starsContainer.addEventListener('click', function(e) {
            if (e.target.tagName === 'I') {
                const clickedRating = parseInt(e.target.dataset.rating);
                hiddenInput.value = clickedRating; // Actualiza el valor del input oculto
                updateStars(clickedRating); // Actualiza la vista
            }
        });
    });
</script>
@endsection
