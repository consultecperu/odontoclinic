<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosortodonciasDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestosortodonciasdetalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuestoortodoncia_id')->unsigned();
            $table->integer('tarifario_id')->unsigned();
            $table->integer('moneda_id')->unsigned();
            $table->string('numero_cuota')->nullable();
            $table->float('costo',10,2)->nullable();
            $table->float('costo_base',10,2)->nullable();
            $table->float('descuento',10,2)->nullable(); 
            $table->smallInteger('tipoplan')->default(1);           
            $table->integer('empleado_id')->unsigned();
            $table->smallInteger('realizado')->default(1);
            $table->smallInteger('descargado')->default(0);
            $table->smallInteger('pagado')->default(0);
            $table->smallInteger('tipo_pagado')->nullable();
            $table->smallInteger('adicional')->default(0);
            $table->integer('laboratorio_id')->unsigned()->nullable();
            $table->float('monto_lab',8,2)->nullable();
            $table->integer('material_id')->unsigned()->nullable();
            $table->float('monto_mat',8,2)->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);              
            $table->foreign('presupuestoortodoncia_id')->references('id')->on('presupuestosortodoncias')->onDelete('cascade'); 
            $table->foreign('tarifario_id')->references('id')->on('tarifarios')->onDelete('cascade'); 
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');             
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');              
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('cascade');              
            $table->foreign('material_id')->references('id')->on('materiales')->onDelete('cascade');  
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
        Schema::dropIfExists('presupuestosortodonciasDetalle');
    }
}
