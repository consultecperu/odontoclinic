<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosoperatoriasDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestosoperatoriasdetalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuestooperatoria_id')->unsigned();
            $table->integer('tarifario_id')->unsigned();
            $table->smallInteger('tarifa')->default(1);
            $table->integer('moneda_id')->unsigned();
            $table->float('deducible',10,2)->nullable();
            $table->float('solocoaseguro',10,2)->nullable();
            $table->float('pago_cliente',10,2)->nullable();
            $table->float('pago_aseguradora',10,2)->nullable();
            $table->float('costo',10,2)->nullable();
            $table->float('costo_base',10,2)->nullable();
            $table->float('descuento',10,2)->nullable();            
            $table->integer('tipo_odontograma')->nullable();
            $table->integer('empleado_id')->unsigned();
            $table->smallInteger('realizado')->default(0);
            $table->smallInteger('descargado')->default(0);
            $table->smallInteger('pagado')->default(0);
            $table->smallInteger('tipo_pagado')->nullable();
            $table->integer('laboratorio_id')->unsigned()->nullable();
            $table->float('monto_lab',8,2)->nullable();
            $table->integer('material_id')->unsigned()->nullable();
            $table->float('monto_mat',8,2)->nullable();
            $table->string('solicitud')->nullable();
            $table->integer('user_id')->unsigned();
            // Dientes del odontograma
            $table->integer('diente_id')->unsigned()->nullable();
            $table->string('caras')->nullable();
            $table->string('letras')->nullable();
            $table->integer('simbologia_id')->unsigned()->nullable();
            // fin Dientes del odontograma
            $table->boolean('activo')->default(true);              
            $table->foreign('presupuestooperatoria_id')->references('id')->on('presupuestosoperatorias')->onDelete('cascade'); 
            $table->foreign('tarifario_id')->references('id')->on('tarifarios')->onDelete('cascade'); 
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');             
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');              
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('cascade');              
            $table->foreign('material_id')->references('id')->on('materiales')->onDelete('cascade');  
            $table->foreign('diente_id')->references('id')->on('dientes')->onDelete('cascade');  
            $table->foreign('simbologia_id')->references('id')->on('simbologias')->onDelete('cascade');  
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
        Schema::dropIfExists('presupuestosoperatoriasdetalle');
    }
}
