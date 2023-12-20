<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_deseo extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio',
        'cantidad',
        'producto_id',
        'deseo_id'
    ];
}
