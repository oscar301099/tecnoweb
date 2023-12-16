<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio',9,2);
            $table->integer('stock');
            $table->text('imagen');
            $table->unsignedBigInteger('categoria_id')->nullable()->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->unsignedBigInteger('marca_id')->nullable()->foreign('marca_id')->references('id')->on('marcas')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
