@extends('layouts.app') {{-- Extiende el layout principal --}}

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-8 max-w-2xl mx-auto my-10">
    <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-8">Detalles de la Reseña</h1>

    <div class="mb-6 p-6 border border-gray-200 rounded-lg bg-gray-50"> {{-- Contenedor con estilo para los detalles --}}
        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">ID:</strong> {{ $reseña->id }}</p>
        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">Comentario:</strong> {{ $reseña->comentario }}</p>
        
        <!-- Mostrar Calificación con Estrellas -->
        <div class="mb-3">
            <p class="text-gray-700 text-lg mb-2"><strong class="font-bold">Calificación:</strong></p>
            <div class="flex items-center space-x-0.5 text-2xl"> {{-- Tamaño de las estrellas --}}
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $reseña->calificacion)
                        <i class="fas fa-star text-yellow-500"></i> {{-- Estrella llena --}}
                    @else
                        <i class="far fa-star text-gray-400"></i> {{-- Estrella vacía --}}
                    @endif
                @endfor
            </div>
        </div>

        <!-- Mostrar Imagen de la reseña -->
        @if($reseña->imagen)
            <div class="mb-4 mt-6"> {{-- Margen superior para separar de la calificación --}}
                <p class="text-gray-700 text-lg mb-2"><strong class="font-bold">Imagen:</strong></p>
                <img src="{{ asset('storage/' . $reseña->imagen) }}" alt="Imagen de la reseña" class="w-64 h-auto object-cover rounded-lg shadow-md border border-gray-200">
            </div>
        @else
            <p class="text-gray-500 text-lg mb-3">No hay imagen para esta reseña.</p>
        @endif

        <!-- Mostrar Producto Relacionado -->
        <p class="text-gray-700 text-lg mb-3 mt-6"> {{-- Margen superior para separar --}}
            <strong class="font-bold">Producto:</strong>
            @if($reseña->producto)
                {{ $reseña->producto->nombre }}
            @else
                <span class="text-red-500">Producto no encontrado</span>
            @endif
        </p>

        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">Creado:</strong> {{ $reseña->created_at->format('d/m/Y H:i') }}</p>
        <p class="text-gray-700 text-lg mb-3"><strong class="font-bold">Actualizado:</strong> {{ $reseña->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="flex justify-end mt-8">
        <a href="{{ route('reseñas.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
            <i class="fas fa-arrow-circle-left mr-2"></i> Volver al Listado
        </a>
    </div>
</div>
@endsection