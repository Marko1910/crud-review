<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ejecuta las migraciones.
     * Agrega la columna 'imagen' a la tabla 'productos'.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Añade la columna 'imagen' de tipo string.
            // ->nullable() significa que el campo no es obligatorio (puede ser nulo).
            // ->after('stock') posiciona esta columna después de la columna 'stock' para una mejor organización.
            $table->string('imagen')->nullable()->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     * Revierte las migraciones.
     * Elimina la columna 'imagen' de la tabla 'productos'.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Elimina la columna 'imagen' si se revierte la migración.
            $table->dropColumn('imagen');
        });
    }
};
