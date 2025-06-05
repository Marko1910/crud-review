@extends('layouts.app') {{-- Extiende el layout principal --}}

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-8 max-w-2xl mx-auto">
    <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-8">Editar Producto</h1>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Campo Nombre -->
        <div class="mb-6">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out" value="{{ old('nombre', $producto->nombre) }}" required>
            @error('nombre')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo Stock -->
        <div class="mb-6">
            <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock:</label>
            <input type="number" name="stock" id="stock" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out" value="{{ old('stock', $producto->stock) }}" required>
            @error('stock')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo Imagen (para el producto) -->
        <div class="mb-6">
            <label for="imagen" class="block text-gray-700 text-sm font-bold mb-2">Imagen del Producto:</label>
            @if($producto->imagen)
                <div class="mb-4">
                    <p class="text-gray-600 text-sm mb-2">Imagen actual:</p>
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen del producto actual" class="w-32 h-32 object-cover rounded-lg shadow-md border border-gray-200">
                </div>
            @endif
            <input type="file" name="imagen" id="imagen" accept="image/*" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200 ease-in-out">
            <p class="text-gray-500 text-xs mt-2">Sube una nueva imagen para reemplazar la actual (opcional).</p>
            @error('imagen')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                <i class="fas fa-save mr-2"></i> Actualizar Producto
            </button>
            <a href="{{ route('productos.index') }}" class="ml-4 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                <i class="fas fa-times-circle mr-2"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
