@extends('layouts.app') {{-- Extiende el layout principal --}}

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-8 mb-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900">Listado de Productos</h1>
        <a href="{{ route('productos.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
            <i class="fas fa-plus-circle mr-2"></i> Crear Producto
        </a>
    </div>

    @if($productos->isEmpty())
        <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
            <p class="text-gray-600 text-xl font-medium">No hay productos registrados aún.</p>
            <p class="text-gray-500 mt-2">¡Comienza a añadir algunos!</p>
        </div>
    @else
        {{-- Cuadrícula de tarjetas de productos más compacta --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($productos as $producto)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out overflow-hidden flex flex-col">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}" class="w-full h-36 object-cover object-center border-b border-gray-200">
                @else
                    <div class="w-full h-36 bg-gray-200 flex items-center justify-center text-gray-500 text-lg font-medium">
                        <i class="fas fa-image text-3xl text-gray-400"></i>
                    </div>
                @endif
                <div class="p-4 flex-grow flex flex-col justify-between text-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $producto->nombre }}</h3>
                        <p class="text-gray-700 text-sm mb-2">Stock: <span class="font-semibold">{{ $producto->stock }}</span></p>
                        
                        {{-- Mostrar Calificación Promedio con Estrellas --}}
                        <div class="flex items-center justify-center space-x-0.5 text-xl mb-3">
                            @php
                                // Asegúrate de que $producto->reseñas_avg_calificacion esté disponible desde el controlador
                                $averageRating = round($producto->reseñas_avg_calificacion ?? 0);
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $averageRating)
                                    <i class="fas fa-star text-yellow-500"></i> {{-- Estrella llena --}}
                                @else
                                    <i class="far fa-star text-gray-300"></i> {{-- Estrella vacía --}}
                                @endif
                            @endfor
                            @if ($producto->reseñas_count > 0)
                                <span class="text-gray-600 text-xs ml-1">({{ $producto->reseñas_count }})</span>
                            @endif
                        </div>
                    </div>
                    {{-- Contenedor de botones de icono redondos con nuevos colores --}}
                    <div class="flex justify-center space-x-2 mt-2">
                        {{-- Botón Ver Detalles (azul elegante) --}}
                        <a href="{{ route('productos.show', $producto->id) }}" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full transition duration-300 ease-in-out shadow-md hover:shadow-lg" title="Ver Detalles">
                            <i class="fas fa-eye text-base"></i>
                        </a>
                        {{-- Botón Editar (gris elegante) --}}
                        <a href="{{ route('productos.edit', $producto->id) }}" class="p-2 bg-gray-700 hover:bg-gray-800 text-white rounded-full transition duration-300 ease-in-out shadow-md hover:shadow-lg" title="Editar">
                            <i class="fas fa-edit text-base"></i>
                        </a>
                        {{-- Botón Eliminar (rojo profundo) --}}
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-700 hover:bg-red-800 text-white rounded-full transition duration-300 ease-in-out shadow-md hover:shadow-lg" title="Eliminar">
                                <i class="fas fa-trash-alt text-base"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
