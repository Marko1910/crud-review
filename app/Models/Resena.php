<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    // ¡IMPORTANTE! Asegúrate de que el nombre de la clase sea Resena (sin la 'ñ')
    class Resena extends Model
    {
        use HasFactory;

        /**
         * The attributes that are mass assignable.
         * Los atributos que se pueden asignar masivamente.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'comentario',
            'calificacion',
            'imagen',
            'producto_id',
        ];

        /**
         * Get the product that owns the review.
         * Obtener el producto al que pertenece la reseña.
         * Define la relación muchos a uno: Una reseña pertenece a un solo producto.
         */
        public function producto()
        {
            return $this->belongsTo(Producto::class, 'producto_id');
        }
    }