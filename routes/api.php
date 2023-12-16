<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::get('configuration', [AuthController::class, 'configuration']);
Route::get('productos', [AuthController::class, 'productos']);
Route::post('updatePerfil/{id}', [AuthController::class, 'UpdatePerfil']);
Route::post('updatePassword/{id}', [AuthController::class, 'UpdatePassword']);
Route::get('pedidos/{id}', [AuthController::class, 'pedidos']);
Route::post('addProducto', [AuthController::class, 'addProducto']);
Route::get('pedido_detalle/{id}', [AuthController::class, 'pedido_detalle']);
Route::get('nombreProducto/{id}', [AuthController::class, 'nombreProducto']);
Route::get('deleteDetalle/{id}', [AuthController::class, 'deleteDetalle']);

Route::get('tipoPagos', [AuthController::class, 'tipoPagos']);
Route::get('tipoEnvios', [AuthController::class, 'tipoEnvios']);
Route::get('promociones', [AuthController::class, 'promociones']);
Route::post('storePedido', [AuthController::class, 'storePedido']);
