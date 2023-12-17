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
        $contador = ContadorPage::where($nombrepagina,'nombrePagina')->first();
        dd($contador);
        if($contador != ""){
            $contador->cantidad=$contador->cantidad+1;
        }else {
            $contador = new ContadorPage();
            $contador->nombre = $nombrepagina;
            $contador->cantidad=$contador->cantidad+1;
        }
        $contador->save();
    }





}
