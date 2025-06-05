<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'stock',
        'imagen', // ¡Asegúrate de que 'imagen' esté aquí para asignación masiva!
    ];

    /**
     * Get the reviews for the product.
     * Obtener las reseñas para el producto.
     * Define la relación uno a muchos: Un producto puede tener muchas reseñas.
     */
    public function reseñas()
    {
        // Un Producto tiene muchas Reseñas, y la clave foránea en la tabla 'reseñas' es 'producto_id'
        return $this->hasMany(Resena::class, 'producto_id'); // Asegúrate de usar 'Resena' si renombraste el modelo
    }
}