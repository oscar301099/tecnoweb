<?php

use App\Http\Controllers\cliente\PerfilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\cliente\vistaCategoriaController;
use App\Http\Controllers\cliente\PedidosCController;
use App\Http\Controllers\pagofacil\CallBackAdminController;
use App\Http\Controllers\pagofacil\ConsumirServicioController;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Producto;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
//RUTAS DEL CLIENTE
Route::get('Categoria/{id}', [vistaCategoriaController::class, 'index'])->name('cliente.categoria.index');
Route::get('perfil', [vistaCategoriaController::class, 'perfil'])->name('cliente.perfil');
Route::get('Editarperfil', [vistaCategoriaController::class, 'EditPerfil'])->name('cliente.editperfil');

Route::resource('datos', PerfilController::class)->names('cliente.datos');

Route::get('changePassword', [PerfilController::class, 'changePassword'])->name('cliente.changePassword');
Route::post('updatePassword', [PerfilController::class, 'updatePassword'])->name('cliente.updatePassword');
Route::resource('Pedidos', PedidosCController::class)->names('cliente.pedidos');
// Route::get('MiPedido/{id}/Productos', [PedidosCController::class, 'indexP'])->name('cliente.pedidos.indexP');


//Route::get('MiPedido', [PedidosCController::class, 'indexP'])->name('cliente.pedidos.indexP');

///agregar desde el carrito
Route::get('MiPedidoC', [PedidosCController::class, 'indexC'])->name('cliente.pedidos.indexC');
Route::post('MiPedido/Guardar_Productos/{id}', [PedidosCController::class, 'storeC'])->name('cliente.pedidos.storeC');



/////ahora con el inicial, agregar desde el pedido
//Route::get('MiPedidoP', [PedidosCController::class, 'indexP'])->name('cliente.pedidos.indexP');
Route::get('MiPedido/{id}/Productos', [PedidosCController::class, 'indexP'])->name('cliente.pedidos.indexP');

Route::post('MiPedido/Guardar_ProductosP/{id}', [PedidosCController::class, 'storeP'])->name('cliente.pedidos.storeP');




Route::get('Carrito', [PedidosCController::class, 'showC'])->name('cliente.carrito.showC');





Route::get('VistaCategoria/{idcategoria}', function ($idcategoria) {
    $productos = Producto::where('categoria_id', $idcategoria)->paginate(3);
    // $pedido = Pedido::where('id', $idpedido)->first();
    $categorias = Categoria::all();
    $marcas = Marca::all();
    return view('cliente.Pedidos.productos', compact('productos', 'marcas', 'categorias'));
})->name('cliente.pedidos.indexCategoria');

Route::delete('Eliminar/detalle/{id}', [PedidosCController::class, 'DetalleDestroy'])->name('cliente.pedidos.DetalleDestroy');

Route::delete('Eliminar/detalleC/{id}', [PedidosCController::class, 'DetalleDestroyC'])->name('cliente.pedidos.DetalleDestroyC');

Route::post('pedidos/create_factura/{id}', [PedidosCController::class, 'CreateFactura'])->name('cliente.pedidos.CreateFactura');
Route::get('/pdf/Cliente/Factura/{id}', 'App\Http\Controllers\admin\PDFController@PDFFacturaCliente')->name('cliente.PDF.FacturaCliente');


Route::get('/pagofacil', function () {
    return view('pagofacil.index');
});
Route::post('/consumirServicio', [ConsumirServicioController::class, 'RecolectarDatos']);
Route::post('/generarQr', [ConsumirServicioController::class, 'generarQr'])->name('admin.generarQr');

Route::post('/consultar', [ConsumirServicioController::class, 'ConsultarEstado']);

Route::post('/venta/pagos/callback', CallBackAdminController::class)->name('admin.pagos.callback');
//Route::get('/venta/pagos/consultar/{venta_id}', ConsultarAdminController::class)->name('admin.pagos.consultar');