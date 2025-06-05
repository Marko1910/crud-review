<?php

    namespace App\Http\Controllers;

    use App\Models\Resena;    // ¡IMPORTANTE! Cambiado de Reseña a Resena
    use App\Models\Producto;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Log;

    class ResenaController extends Controller
    {
        /**
         * Muestra una lista de todas las reseñas.
         *
         * @return \Illuminate\View\View
         */
        public function index()
        {
            // Obtiene todas las reseñas y carga eager load el producto relacionado para evitar N+1 queries
            $reseñas = Resena::with('producto')->get(); // ¡IMPORTANTE! Se usa Resena aquí

            // Retorna la vista 'resenas.index' y le pasa la colección de reseñas
            return view('resenas.index', compact('reseñas'));
        }

        /**
         * Muestra el formulario para crear una nueva reseña.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            $productos = Producto::all();
            return view('resenas.create', compact('productos'));
        }

        /**
         * Almacena una reseña recién creada en la base de datos, incluyendo la imagen.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store(Request $request)
        {
            $request->validate([
                'comentario' => 'required|string|max:500',
                'calificacion' => 'required|integer|min:1|max:5',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'producto_id' => 'required|exists:productos,id',
            ]);

            $data = $request->all();

            if ($request->hasFile('imagen')) {
                $path = $request->file('imagen')->store('reseñas_imagenes', 'public');
                $data['imagen'] = $path;
            }

            try {
                Resena::create($data); // ¡IMPORTANTE! Se usa Resena aquí

                return redirect()->route('reseñas.index')
                                    ->with('success', 'Reseña creada exitosamente.');
            } catch (\Exception $e) {
                Log::error('Error al crear reseña: ' . $e->getMessage());
                if (isset($data['imagen']) && Storage::disk('public')->exists($data['imagen'])) {
                    Storage::disk('public')->delete($data['imagen']);
                }
                return redirect()->back()
                                    ->withInput()
                                    ->with('error', 'Hubo un error al crear la reseña.');
            }
        }

        /**
         * Muestra la reseña especificada.
         *
         * @param  \App\Models\Resena  $reseña // ¡IMPORTANTE! Se espera Resena aquí
         * @return \Illuminate\View\View
         */
        public function show(Resena $reseña) // ¡IMPORTANTE! Se espera Resena aquí
        {
            $reseña->load('producto');
            return view('resenas.show', compact('reseña'));
        }

        /**
         * Muestra el formulario para editar la reseña especificada.
         *
         * @param  \App\Models\Resena  $reseña // ¡IMPORTANTE! Se espera Resena aquí
         * @return \Illuminate\View\View
         */
        public function edit(Resena $reseña) // ¡IMPORTANTE! Se espera Resena aquí
        {
            $productos = Producto::all();
            return view('resenas.edit', compact('reseña', 'productos'));
        }

        /**
         * Actualiza la reseña especificada en la base de datos.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\Resena  $reseña // ¡IMPORTANTE! Se espera Resena aquí
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update(Request $request, Resena $reseña) // ¡IMPORTANTE! Se espera Resena aquí
        {
            $request->validate([
                'comentario' => 'required|string|max:500',
                'calificacion' => 'required|integer|min:1|max:5',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'producto_id' => 'required|exists:productos,id',
            ]);

            $data = $request->all();

            if ($request->hasFile('imagen')) {
                if ($reseña->imagen && Storage::disk('public')->exists($reseña->imagen)) {
                    Storage::disk('public')->delete($reseña->imagen);
                }
                $path = $request->file('imagen')->store('reseñas_imagenes', 'public');
                $data['imagen'] = $path;
            } else {
                unset($data['imagen']);
            }

            try {
                $reseña->update($data); // ¡IMPORTANTE! Se usa Resena aquí

                return redirect()->route('reseñas.index')
                                    ->with('success', 'Reseña actualizada exitosamente.');
            } catch (\Exception $e) {
                Log::error('Error al actualizar reseña: ' . $e->getMessage());
                return redirect()->back()
                                    ->withInput()
                                    ->with('error', 'Hubo un error al actualizar la reseña.');
            }
        }

        /**
         * Elimina la reseña especificada de la base de datos.
         *
         * @param  \App\Models\Resena  $reseña // ¡IMPORTANTE! Se espera Resena aquí
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy(Resena $reseña) // ¡IMPORTANTE! Se espera Resena aquí
        {
            try {
                if ($reseña->imagen && Storage::disk('public')->exists($reseña->imagen)) {
                    Storage::disk('public')->delete($reseña->imagen);
                }

                $reseña->delete(); // ¡IMPORTANTE! Se usa Resena aquí

                return redirect()->route('reseñas.index')
                                    ->with('success', 'Reseña eliminada exitosamente.');
            } catch (\Exception $e) {
                Log::error('Error al eliminar reseña: ' . $e->getMessage());
                return redirect()->back()
                                    ->with('error', 'Hubo un error al eliminar la reseña.');
            }
        }
    }
    
