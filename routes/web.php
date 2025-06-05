<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; // Asegúrate de importar tu controlador de Productos
use App\Http\Controllers\ResenaController;   // Asegúrate de importar tu controlador de Reseñas

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta de inicio o raíz de la aplicación.
// Cuando el usuario acceda a la URL principal ("/"), será redirigido
// al listado de productos. Puedes cambiar esto si deseas una página de inicio diferente.
Route::get('/', function () {
    return redirect()->route('productos.index');
});

// Rutas de recursos para el controlador de Productos.
// Esto crea automáticamente las siguientes rutas:
// GET    /productos            -> ProductoController@index   (mostrar todos los productos)
// GET    /productos/create     -> ProductoController@create  (mostrar formulario para crear)
// POST   /productos            -> ProductoController@store   (guardar nuevo producto)
// GET    /productos/{producto} -> ProductoController@show    (mostrar un producto específico)
// GET    /productos/{producto}/edit -> ProductoController@edit (mostrar formulario para editar)
// PUT/PATCH /productos/{producto} -> ProductoController@update (actualizar producto)
// DELETE /productos/{producto} -> ProductoController@destroy (eliminar producto)
Route::resource('productos', ProductoController::class);

// Rutas de recursos para el controlador de Reseñas.
// Esto crea automáticamente las siguientes rutas para las reseñas:
// GET    /reseñas            -> ReseñaController@index   (mostrar todas las reseñas)
// GET    /reseñas/create     -> ReseñaController@create  (mostrar formulario para crear)
// POST   /reseñas            -> ReseñaController@store   (guardar nueva reseña)
// GET    /reseñas/{reseña}   -> ReseñaController@show    (mostrar una reseña específica)
// GET    /reseñas/{reseña}/edit -> ReseñaController@edit (mostrar formulario para editar)
// PUT/PATCH /reseñas/{reseña} -> ReseñaController@update (actualizar reseña)
// DELETE /reseñas/{reseña} -> ReseñaController@destroy (eliminar reseña)
Route::resource('reseñas', ResenaController::class);