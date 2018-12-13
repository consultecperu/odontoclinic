<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratorioServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorioservicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('laboratorio_id')->unsigned();
            $table->integer('fase_id')->nullable()->unsigned();
            $table->float('costo_lab',8,2)->nullable();
            $table->float('costo_doctor',8,2)->nullable();
            $table->string('nombre_servicio')->nullable();
            $table->integer('moneda_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('cascade');              
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');  
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');              
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
        Schema::dropIfExists('laboratorioservicios');
    }
}
