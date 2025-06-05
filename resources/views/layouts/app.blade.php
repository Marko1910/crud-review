<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrador de Reseñas</title>
    @vite('resources/css/app.css') {{-- Asegúrate de que este es el camino correcto para tu CSS compilado de Tailwind --}}
    <!-- Link de Font Awesome CDN - ¡CRUCIAL para que los iconos se muestren! -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" xintegrity="sha512-Fo3rlalK/46tZ6jB+l52u5l5v2/FfB/4J0w9g/VwWz7r722P/t9r92G1t/2z+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="flex flex-col min-h-screen bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Barra de navegación con un gradiente de azul a morado más atractivo -->
    <nav class="bg-gradient-to-r from-blue-700 to-purple-800 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold tracking-wide">Admin Reseñas</a>
            <div>
                {{-- Botón Productos con color de fondo y texto por defecto, y cambio al pasar el mouse --}}
                <a href="{{ route('productos.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold tracking-wide hover:bg-white hover:text-purple-700 transition duration-300 ease-in-out transform hover:scale-105 mr-3">Productos</a>
                {{-- Botón Reseñas con color de fondo y texto por defecto, y cambio al pasar el mouse --}}
                <a href="{{ route('reseñas.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold tracking-wide hover:bg-white hover:text-purple-700 transition duration-300 ease-in-out transform hover:scale-105">Reseñas</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4 flex-grow">
        @yield('content') {{-- Aquí se inyectará el contenido de las vistas individuales --}}
    </div>
    
    <!-- Pie de página -->
    <footer class="bg-gray-800 text-white p-6 text-center mt-12 shadow-inner">
        &copy; {{ date('Y') }} Administrador de Reseñas. Todos los derechos reservados.
    </footer>
</body>
</html>

