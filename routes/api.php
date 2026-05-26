<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas de la API para la aplicación. Estas
| rutas son cargadas por el framework con el prefijo "/api".
|
*/

// Rutas para Productos
Route::get('/productos', [ProductoController::class, 'index']);

// Rutas para Ventas
Route::get('/ventas', [VentaController::class, 'index']);
Route::post('/ventas', [VentaController::class, 'store']);
