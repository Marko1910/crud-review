@extends('layouts.app') {{-- Extiende el layout principal --}}

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-8 max-w-2xl mx-auto">
    <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-8">Detalles del Producto</h1>

    <div class="mb-6">
        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">ID:</strong> {{ $producto->id }}</p>
        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">Nombre:</strong> {{ $producto->nombre }}</p>
        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">Stock:</strong> {{ $producto->stock }}</p>

        <!-- Mostrar Imagen del producto -->
        @if($producto->imagen)
            <div class="mb-4">
                <p class="text-gray-700 text-lg mb-2"><strong class="font-bold">Imagen:</strong></p>
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen del producto" class="w-64 h-auto object-cover rounded-lg shadow-md border border-gray-200">
            </div>
        @else
            <p class="text-gray-500 text-lg mb-3">No hay imagen para este producto.</p>
        @endif

        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">Creado:</strong> {{ $producto->created_at->format('d/m/Y H:i') }}</p>
        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">Actualizado:</strong> {{ $producto->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="flex justify-end mt-8">
        <a href="{{ route('productos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
            <i class="fas fa-arrow-circle-left mr-2"></i> Volver al Listado
        </a>
    </div>
</div>
@endsection