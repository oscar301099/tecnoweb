<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'categoria_id',
        'marca_id'
    ];
        //relacion uno a muchos Producto-Categoria(inversa)
        public function categoria(){
            return $this->belongsTo('App\Models\Categoria');
        }

        //relacion uno a muchos Producto-Marca(inversa)
        public function marca(){
            return $this->belongsTo('App\Models\Marca');
        }
}
