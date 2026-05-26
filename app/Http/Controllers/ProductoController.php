<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Obtiene el listado de todos los productos.
     */
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }
}
