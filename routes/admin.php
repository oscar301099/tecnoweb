<?php

use App\Http\Controllers\admin\BitacoraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\PerfilController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProductoController;
use App\Http\Controllers\admin\CategoriaController;
use App\Http\Controllers\admin\ClienteController;
use App\Http\Controllers\admin\MarcaController;
use App\Http\Controllers\admin\ProveedorController;
use App\Http\Controllers\admin\Detalle_productoController;
use App\Http\Controllers\admin\PedidoController;
use App\Http\Controllers\admin\FacturaController;
use App\Http\Controllers\admin\Tipo_envioController;
use App\Http\Controllers\admin\Tipo_PagoController;
use App\Http\Controllers\admin\ConfiguracionController;
use App\Http\Controllers\admin\detalle_pedidoController;
use App\Http\Controllers\admin\EmpleadoController;
use App\Http\Controllers\admin\PromocionController;


Route::get('',[HomeController::class, 'index'])->name('admin.home');

Route::resource('perfil', PerfilController::class)->names('admin.perfil');
Route::resource('users', UserController::class)->names('admin.users');
Route::resource('productos', ProductoController::class)->names('admin.productos');
Route::resource('categorias', CategoriaController::class)->names('admin.categorias');
Route::resource('marcas', MarcaController::class)->names('admin.marcas');
Route::resource('proveedores', ProveedorController::class)->names('admin.proveedores');
Route::resource('detalle_productos', Detalle_productoController::class)->names('admin.detalle_productos');
Route::resource('configuracion', ConfiguracionController::class)->names('admin.configuracion');
Route::resource('tipo_envios', Tipo_envioController::class)->names('admin.tipo_envios');
Route::resource('tipo_pagos', Tipo_PagoController::class)->names('admin.tipo_pagos');
Route::resource('Bitacora',BitacoraController::class)->names('Bitacora');
Route::resource('promociones', PromocionController::class)->names('admin.promociones');
Route::resource('clientes', ClienteController::class)->names('admin.clientes');
Route::resource('empleados', EmpleadoController::class)->names('admin.empleados');

//falta
Route::resource('pedidos', PedidoController::class)->names('admin.pedidos');
Route::resource('detalle_pedidos', detalle_pedidoController::class)->names('admin.detalle_pedidos');
Route::resource('facturas', FacturaController::class)->names('admin.facturas');


Route::get('pedidos/entregado/{id}',[PedidoController::class,'entregado'])->name('admin.pedidos.entregado');
Route::get('pedidos/espera/{id}',[PedidoController::class,'espera'])->name('admin.pedidos.espera');
Route::post('pedidos/create_factura/{id}',[PedidoController::class,'CreateFactura'])->name('admin.pedidos.CreateFactura');
Route::post('pedidos/DestroyFactura/{id}',[PedidoController::class,'DestroyFactura'])->name('admin.pedidos.DestroyFactura');



Route::get('detalle_pedidos/Productos/{id}',[detalle_pedidoController::class,'indexP'])->name('admin.detalle_pedidos.indexP');
Route::post('detalle_pedidos/Store_Productos/{id}',[detalle_pedidoController::class,'storeP'])->name('admin.detalle_pedidos.storeP');
Route::get('detalle_pedidos/editGeneral/{id}',[detalle_pedidoController::class,'editGeneral'])->name('admin.detalle_pedidos.editGeneral');

//Buscar bitacora dinamica
Route::get('BitacoraDinamica',[BitacoraController::class,'textBitacora'])->name('admin.bitacora.textBitacora');
Route::get('reporteExamen',[ProductoController::class,'reporte'])->name('admin.examen');


//Generar PDF
Route::get('/pdf/usuarios', 'App\Http\Controllers\admin\PDFController@PDFUsuarios')->name('admin.PDF.usuarios');
Route::get('/pdf/clientes', 'App\Http\Controllers\admin\PDFController@PDFClientes')->name('admin.PDF.clientes');
Route::get('/pdf/empleados', 'App\Http\Controllers\admin\PDFController@PDFEmpleados')->name('admin.PDF.empleados');
Route::get('/pdf/Factura/{id}', 'App\Http\Controllers\admin\PDFController@PDFFactura')->name('admin.PDF.factura');
Route::get('/pdf/bitacoraPDF', 'App\Http\Controllers\admin\PDFController@PDFBitacora')->name('admin.PDF.bitacoras');
Route::get('bitacora/downloadTxt', [App\Http\Controllers\admin\BitacoraController::class, 'downloadTxt'])->name('bitacora.downloadTxt');



