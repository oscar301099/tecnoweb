<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_carrito extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio',
        'cantidad',
        'producto_id',
        'carrito_id'
    ];
}
