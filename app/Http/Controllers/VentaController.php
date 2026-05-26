<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Obtiene el listado de todas las ventas con su respectivo producto.
     */
    public function index()
    {
        // Traemos las ventas ordenadas por fecha de creación descendente y cargamos la relación 'producto'
        $ventas = Venta::with('producto')->latest()->get();
        return response()->json($ventas, 200);
    }

    /**
     * Registra una nueva venta, valida stock y disminuye la cantidad del inventario.
     */
    public function store(Request $request)
    {
        // Validamos los datos de entrada
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ], [
            'producto_id.required' => 'Debe seleccionar un producto.',
            'producto_id.exists' => 'El producto seleccionado no es válido.',
            'cantidad.required' => 'Debe ingresar una cantidad.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
        ]);

        try {
            // Usamos una transacción de base de datos para asegurar consistencia
            $venta = DB::transaction(function () use ($request) {
                // Buscamos el producto y bloqueamos la fila para evitar condiciones de carrera (race conditions)
                $producto = Producto::lockForUpdate()->find($request->producto_id);

                // Validamos que haya stock suficiente
                if ($producto->stock < $request->cantidad) {
                    throw new \Exception("Stock insuficiente para el producto {$producto->nombre}. Stock disponible: {$producto->stock}.");
                }

                // Restamos el stock del producto
                $producto->stock -= $request->cantidad;
                $producto->save();

                // Calculamos el total de la venta
                $total = $producto->precio * $request->cantidad;

                // Creamos la venta
                return Venta::create([
                    'producto_id' => $producto->id,
                    'cantidad' => $request->cantidad,
                    'total' => $total
                ]);
            });

            // Cargamos la relación para devolver la respuesta con el producto
            $venta->load('producto');

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada con éxito.',
                'venta' => $venta
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422); // Código 422: Unprocessable Entity (Error de validación de negocio)
        }
    }
}
