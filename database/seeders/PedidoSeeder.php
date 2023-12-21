<?php

namespace Database\Seeders;

use App\Models\Carrito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Configuration;
use App\Models\Deseo;
use App\Models\detalle_pedido;
use App\Models\Marca;
use App\Models\Pedido;
use App\Models\Promocion;
use App\Models\Proveedor;
use App\Models\Tipo_envio;
use App\Models\Tipo_pago;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

          // Obtén los 6 productos de la base de datos
          $productos = Producto::limit(6)->get();

          // Genera 10 pedidos de ejemplo
          for ($i = 1; $i <= 10; $i++) {
              $pedido = Pedido::create([
                  'tcNroPago' => '123456789' . $i,
                  'direccion' => 'Calle Principal ' . $i,
                  'estado' => 'En proceso',
                  'fecha_entrega' => now()->addDays(7),
                  'fecha_pedido' => now(),
                  'cliente_id' => 3, // Ajusta el cliente_id según tu base de datos
                  'tipoEnvio_id' => 1, // Ajusta el tipoEnvio_id según tu base de datos
                  'tipoPago_id' => 1, // Ajusta el tipoPago_id según tu base de datos
                  'promocion_id' => 1, // Ajusta el promocion_id según tu base de datos
              ]);
  
              // Variable para almacenar el total del pedido
              $totalPedido = 0;
  
              // Genera un número aleatorio de detalles de pedido por pedido (entre 1 y 5)
              $numDetalles = rand(1, 5);
  
              // Agrega detalles de pedido al pedido actual
              for ($j = 0; $j < $numDetalles; $j++) {
                  $producto = $productos->random();
  
                  $cantidad = rand(1, 10); // Cantidad aleatoria
                  $precio = $producto->precio; // Precio unitario del producto
  
                  detalle_pedido::create([
                      'precio' => $precio,
                      'cantidad' => $cantidad,
                      'producto_id' => $producto->id,
                      'pedido_id' => $pedido->id,
                  ]);
  
                  // Suma el total del producto al total del pedido
                  $totalPedido += $precio * $cantidad;
              }
  
              // Actualiza el total del pedido con el total calculado
              $pedido->update(['total' => $totalPedido]);
          }
    }
}
