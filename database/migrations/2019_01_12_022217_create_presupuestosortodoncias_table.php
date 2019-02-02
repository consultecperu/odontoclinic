<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosortodonciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestosortodoncias', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha_registro')->nullable();
            $table->integer('paciente_id')->unsigned();             
            $table->integer('empleado_id')->unisgned();           
            $table->integer('codigo')->nullable();
            $table->integer('cuotas')->nullable();
            $table->float('cuota_inicial',8,2)->nullable();
            $table->float('descuento',8,2)->nullable();
            $table->float('control_mensual',8,2)->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('tipocambio_id')->unsigned();
            $table->integer('estadopresupuesto_id')->unsigned();
            $table->integer('moneda_id')->unsigned();
            $table->float('total_dolares',8,2)->nullable();
            $table->float('total_soles',8,2)->nullable();
            $table->float('total',8,2)->nullable();
            $table->integer('sede_id')->unsigned();
            $table->integer('estado_seguimiento')->nullable();
            $table->float('cuota_inicial_base',8,2)->nullable();
            $table->float('control_mensual_base',8,2)->nullable();
            $table->integer('user_id')->unsigned();
            $table->float('saldo',8,2)->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade'); 
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade'); 
            $table->foreign('tipocambio_id')->references('id')->on('tipocambios')->onDelete('cascade');  
            $table->foreign('estadopresupuesto_id')->references('id')->on('estadopresupuestos')->onDelete('cascade');  
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');             
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');            
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
        Schema::dropIfExists('presupuestosortodoncias');
    }
}
