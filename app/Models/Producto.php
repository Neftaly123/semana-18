<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = ['nombre', 'precio', 'stock'];

    // Relación de uno a muchos: Un producto puede tener muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
