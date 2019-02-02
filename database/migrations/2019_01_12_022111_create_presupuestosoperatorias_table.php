<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosoperatoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestosoperatorias', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha_registro')->nullable();
            $table->integer('paciente_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->integer('moneda_id')->unsigned()->nullable();
            $table->string('numero_presupuesto',20)->nullable();
            $table->integer('plan_id')->unsigned()->nullable();
            $table->integer('poliza_id')->unsigned()->nullable();
            $table->integer('tipo_presupuesto')->nullable();
            $table->integer('estado_seguimiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('estadopresupuesto_id')->unsigned();
            $table->integer('tipocambio_id')->unsigned();
            $table->integer('sede_id')->unsigned();
            $table->float('pago_cliente')->nullable();
            $table->float('pago_aseguradora')->nullable();
            $table->float('pago_total')->nullable();
            $table->integer('user_id')->unsigned();
            $table->float('saldo',8,2)->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade'); 
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade'); 
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');             
            $table->foreign('poliza_id')->references('id')->on('polizas')->onDelete('cascade');              
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade');              
            $table->foreign('estadopresupuesto_id')->references('id')->on('estadopresupuestos')->onDelete('cascade');  
            $table->foreign('tipocambio_id')->references('id')->on('tipocambios')->onDelete('cascade');  
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
        Schema::dropIfExists('presupuestosoperatorias');
    }
}
