@extends('layouts.app') {{-- Extiende el layout principal --}}

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-8 mb-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900">Listado de Reseñas</h1>
        <a href="{{ route('reseñas.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
            <i class="fas fa-plus-circle mr-2"></i> Crear Reseña
        </a>
    </div>

    @if($reseñas->isEmpty())
        <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
            <p class="text-gray-600 text-xl font-medium">No hay reseñas registradas aún.</p>
            <p class="text-gray-500 mt-2">¡Sé el primero en añadir una reseña!</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border-separate border-spacing-y-2">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider rounded-tl-lg">ID</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Imagen</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Comentario</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Calificación</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Producto</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider rounded-tr-lg">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($reseñas as $reseña)
                    <tr class="shadow-sm hover:shadow-md transition-shadow duration-200">
                        <td class="py-4 px-6 text-gray-800 text-lg font-medium rounded-l-lg">{{ $reseña->id }}</td>
                        <td class="py-4 px-6">
                            @if($reseña->imagen)
                                <img src="{{ asset('storage/' . $reseña->imagen) }}" alt="Imagen de reseña" class="w-16 h-16 object-cover rounded-full shadow-sm">
                            @else
                                <span class="text-gray-400">Sin imagen</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-gray-800 text-lg font-medium max-w-xs truncate">{{ $reseña->comentario }}</td>
                        <td class="py-4 px-6 text-gray-800 text-lg font-medium">{{ $reseña->calificacion }}</td>
                        <td class="py-4 px-6 text-gray-800 text-lg font-medium">
                            @if($reseña->producto)
                                {{ $reseña->producto->nombre }}
                            @else
                                <span class="text-red-500">Producto no encontrado</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 space-x-3 rounded-r-lg">
                            <a href="{{ route('reseñas.show', $reseña->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full transition duration-300 ease-in-out">
                                <i class="fas fa-eye mr-1"></i> Ver
                            </a>
                            <a href="{{ route('reseñas.edit', $reseña->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-full transition duration-300 ease-in-out">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </a>
                            <form action="{{ route('reseñas.destroy', $reseña->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reseña?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-full transition duration-300 ease-in-out">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection