<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ejecuta las migraciones.
     * Esto crea la tabla 'productos'.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Columna autoincremental de clave primaria
            $table->string('nombre'); // Columna para el nombre del producto, tipo string
            $table->integer('stock'); // Columna para el stock del producto, tipo entero
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' para marcas de tiempo automáticas
        });
    }

    /**
     * Reverse the migrations.
     * Revierte las migraciones.
     * Esto elimina la tabla 'productos' si se revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};