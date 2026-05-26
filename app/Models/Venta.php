<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = ['producto_id', 'cantidad', 'total'];

    // Relación de muchos a uno: Una venta pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
