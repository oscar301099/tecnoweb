<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContadorPage extends Model
{
    use HasFactory;
    protected $table = 'contador_page';

    public static function SumarContador($nombrepagina)
    {
        $contador = ContadorPage::where('nombrePagina', $nombrepagina)->first();
        if ($contador) {
            $contador->cantidad = $contador->cantidad + 1;
        } else {
            $contador = new ContadorPage();
            $contador->nombrePagina = $nombrepagina;
            $contador->cantidad = 1;
        }
        $contador->save();
    }



}
