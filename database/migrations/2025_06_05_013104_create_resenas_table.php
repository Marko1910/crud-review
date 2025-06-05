<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ejecuta las migraciones.
     * Esto crea la tabla 'reseñas'.
     */
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id(); // Columna autoincremental de clave primaria
            $table->text('comentario'); // Columna para el texto del comentario de la reseña, tipo texto largo
            $table->integer('calificacion'); // Columna para la calificación (ej. 1-5), tipo entero
            $table->string('imagen')->nullable(); // Columna para la ruta de la imagen, puede ser nula
            
            // Define la clave foránea 'producto_id' que hace referencia a la columna 'id' de la tabla 'productos'.
            // onDelete('cascade') significa que si un producto es eliminado, todas sus reseñas asociadas también serán eliminadas.
            $table->foreignId('producto_id')
                  ->constrained('productos') // Indica que referencia a la tabla 'productos'
                  ->onDelete('cascade');     // Configura la acción al eliminar un producto
            
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' para marcas de tiempo automáticas
        });
    }

    /**
     * Reverse the migrations.
     * Revierte las migraciones.
     * Esto elimina la tabla 'reseñas' si se revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};