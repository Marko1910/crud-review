<?php

namespace App\Http\Controllers;

use App\Models\Producto; // Importa el modelo Producto
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Útil para depuración
use Illuminate\Support\Facades\Storage; // ¡Importante para manejar archivos!

class ProductoController extends Controller
{
    /**
     * Muestra una lista de todos los productos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productos = Producto::withAvg('reseñas', 'calificacion')->withCount('reseñas')->get();
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Almacena un producto recién creado en la base de datos, incluyendo la imagen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida los datos de entrada del formulario, incluyendo la imagen
        $request->validate([
            'nombre' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación para la imagen: opcional, tipo imagen, con extensiones y tamaño máximo
        ]);

        $data = $request->all();

        // Manejo de la subida de la imagen
        if ($request->hasFile('imagen')) {
            // Guarda la imagen en el disco 'public' dentro de la carpeta 'productos_imagenes'
            // y obtiene la ruta relativa al disco.
            $path = $request->file('imagen')->store('productos_imagenes', 'public');
            $data['imagen'] = $path; // Almacena esta ruta en los datos a guardar en la DB
        } else {
            // Si no se sube ninguna imagen, asegúrate de que el campo 'imagen' no se intente guardar como algo que no sea null
            $data['imagen'] = null;
        }


        try {
            Producto::create($data); // Crea un nuevo producto con los datos validados

            return redirect()->route('productos.index')
                                ->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear producto: ' . $e->getMessage());
            // Si hubo un error al guardar en la DB, elimina la imagen si se subió
            if (isset($data['imagen']) && Storage::disk('public')->exists($data['imagen'])) {
                Storage::disk('public')->delete($data['imagen']);
            }
            return redirect()->back()
                                ->withInput()
                                ->with('error', 'Hubo un error al crear el producto.');
        }
    }

    /**
     * Muestra el producto especificado.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar el producto especificado.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza el producto especificado en la base de datos, incluyendo la imagen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Producto $producto)
    {
        // Valida los datos de entrada del formulario de edición
        $request->validate([
            'nombre' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación para la imagen
        ]);

        $data = $request->all();

        // Manejo de la actualización de la imagen
        if ($request->hasFile('imagen')) {
            // Si existe una imagen anterior para este producto, la elimina del almacenamiento
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            // Guarda la nueva imagen
            $path = $request->file('imagen')->store('productos_imagenes', 'public');
            $data['imagen'] = $path; // Almacena la ruta de la nueva imagen
        } else {
            // Si no se sube una nueva imagen, mantenemos la imagen existente.
            // Si el input 'imagen' no se envía, Laravel no lo incluirá en $request->all()
            // Entonces, si queremos que la imagen existente no se borre, no debemos sobrescribir 'imagen' a null.
            // Si el usuario quiere eliminar la imagen, necesitaría un checkbox "Eliminar imagen" y lógica adicional.
            // Por defecto, si no se sube, se mantiene la actual.
            unset($data['imagen']); // Evita que se sobreescriba con null si no se envía nueva imagen
        }

        try {
            $producto->update($data); // Actualiza el producto existente

            return redirect()->route('productos.index')
                                ->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar producto: ' . $e->getMessage());
            return redirect()->back()
                                ->withInput()
                                ->with('error', 'Hubo un error al actualizar el producto.');
        }
    }

    /**
     * Elimina el producto especificado de la base de datos.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Producto $producto)
    {
        try {
            // Eliminar la imagen asociada antes de eliminar el producto
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->delete();

            return redirect()->route('productos.index')
                                ->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar producto: ' . $e->getMessage());
            return redirect()->back()
                                ->with('error', 'Hubo un error al eliminar el producto.');
        }
    }
}