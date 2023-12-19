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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('tcNroPago')->nullable();
            $table->string('direccion');
            $table->string('estado');
            $table->string('estado_pago');
            $table->dateTime('fecha_entrega')->nullable();
            $table->dateTime('fecha_pedido')->nullable();
            $table->float('total',9,2)->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable()->foreign('cliente_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('tipoEnvio_id')->nullable()->foreign('tipoEnvio_id')->references('id')->on('tipo_envios')->onDelete('set null');
            $table->unsignedBigInteger('tipoPago_id')->nullable()->foreign('tipoPago_id')->references('id')->on('tipo_pagos')->onDelete('set null');
            $table->unsignedBigInteger('promocion_id')->nullable()->foreign('promocion_id')->references('id')->on('promocions')->onDelete('set null');
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
        Schema::dropIfExists('pedidos');
    }
};