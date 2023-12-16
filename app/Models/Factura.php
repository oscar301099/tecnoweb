<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nit',
        'pago_total',
        'pago_neto',
        'pedido_id'
    ];
}
