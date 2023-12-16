<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = [
        'direccion',
        'estado',
        'fecha_entrega',
        'fecha_pedido',
        'total',
        'cliente_id',
        'tipoEnvio_id',
        'tipoPago_id',
        'promocion_id'
    ];
}
