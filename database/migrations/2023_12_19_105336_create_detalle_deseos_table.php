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
        Schema::create('detalle_deseos', function (Blueprint $table) {
            $table->id();
            $table->float('precio', 9, 2);
            $table->integer('cantidad');
            $table->unsignedBigInteger('producto_id')->nullable()->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
            $table->unsignedBigInteger('deseo_id')->nullable()->foreign('deseo_id')->references('id')->on('deseos')->onDelete('set null');
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
        Schema::dropIfExists('detalle_deseos');
    }
};
