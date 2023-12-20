<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'cliente_id'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_carritos')
        ->withPivot(['cantidad', 'precio'])
        ->withTimestamps();
    }

    public function agregarProducto($productoId, $cantidad)
    {
        $this->productos()->syncWithoutDetaching([
            $productoId => ['cantidad' => $cantidad],
        ]);
    }

}
