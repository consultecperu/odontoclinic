<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrespuestooperatoriaDienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestooperatoria_diente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuestooperatoria_id')->unsigned();
            $table->integer('diente_id')->unsigned();           
            $table->foreign('presupuestooperatoria_id')->references('id')->on('presupuestosoperatorias');
            $table->foreign('diente_id')->references('id')->on('dientes');
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
        Schema::dropIfExists('presupuestooperatoria_diente');
    }
}
