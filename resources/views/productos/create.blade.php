@extends('layouts.app') {{-- Extiende el layout principal --}}

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-8 max-w-md mx-auto my-10"> {{-- max-w-md para hacerlo más pequeño y sutil --}}
    <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-8">Crear Nuevo Producto</h1>

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Protección CSRF de Laravel --}}

        <!-- Campo Nombre -->
        <div class="mb-5">
            <label for="nombre" class="block text-gray-700 text-sm font-semibold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out placeholder-gray-400" value="{{ old('nombre') }}" placeholder="Nombre del producto" required>
            @error('nombre')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo Stock -->
        <div class="mb-5">
            <label for="stock" class="block text-gray-700 text-sm font-semibold mb-2">Stock:</label>
            <input type="number" name="stock" id="stock" min="0" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out placeholder-gray-400" placeholder="Cantidad en stock" value="{{ old('stock') }}" required>
            @error('stock')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo Imagen con Vista Previa -->
        <div class="mb-6">
            <label for="imagen" class="block text-gray-700 text-sm font-semibold mb-2">Imagen del Producto:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200 ease-in-out" onchange="previewImage(event)">
            <p class="text-gray-500 text-xs mt-2">Sube una imagen para el producto (opcional).</p>
            @error('imagen')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
            
            {{-- Contenedor para la vista previa de la imagen --}}
            <div class="mt-4 flex justify-center">
                <img id="imagePreview" src="https://placehold.co/200x200/e2e8f0/64748b?text=Preview" alt="Vista previa de la imagen" class="w-48 h-48 object-cover rounded-lg shadow-md border border-gray-200">
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end mt-6 space-x-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                <i class="fas fa-save mr-2"></i> Guardar Producto
            </button>
            <a href="{{ route('productos.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2.5 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                <i class="fas fa-times-circle mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Función para mostrar una vista previa de la imagen seleccionada
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            document.getElementById('imagePreview').src = "https://placehold.co/200x200/e2e8f0/64748b?text=Preview";
        }
    }
</script>
@endsection

