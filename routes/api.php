<?php

use App\Http\Controllers\AuthController;
use App\Models\ProveedorAutorizado;
use App\Http\Controllers\ProveedoresAutorizados;
use App\Http\Controllers\ProveedorPdfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Obtener todos los proveedores autorizados
Route::get('/proveedores-autorizados', [ProveedoresAutorizados::class, 'index'])->middleware('auth:sanctum');

//Crear un proveedor autorizado
Route::post('/proveedores-autorizados', [ProveedoresAutorizados::class, 'store'])->middleware('auth:sanctum');

//Generar un PDF de proveedores autorizados
Route::get('/generar-pdf-proveedores', [ProveedorPdfController::class, 'generarPdfProveedores'])->middleware('auth:sanctum');

Route::prefix('proveedores')->group(function() {
    Route::get('/pdfs', [ProveedorPdfController::class, 'listarPdf']);
    Route::get('/pdfs/{id}/descargar', [ProveedorPdfController::class, 'descargarPdf']);
    Route::delete('/pdfs/{id}/eliminar', [ProveedorPdfController::class, 'eliminarPdf']);
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/proveedores/por-fecha', [ProveedoresAutorizados::class, 'proveedoresPorCategoria'])->middleware('auth:sanctum');
Route::get('/proveedores/por-categoria', [ProveedoresAutorizados::class, 'proveedoresPorFecha'])->middleware('auth:sanctum');
