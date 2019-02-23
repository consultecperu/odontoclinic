<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sede_id')->unsigned()->nullable();
            $table->integer('ptoventa')->nullable();
            $table->smallInteger('origen')->nullable();
            $table->integer('presupuestooperatoria_id')->unsigned()->nullable();
            $table->integer('presupuestoortodoncia_id')->unsigned()->nullable();
            $table->integer('empleado_id')->unsigned();
            $table->integer('empresapaciente_id')->unsigned()->nullable();
            $table->integer('tipodocumento_id')->unsigned();
            $table->string('serie')->nullable();
            $table->string('numero')->nullable();
            $table->float('deducible')->nullable();
            $table->float('coaseguro')->nullable();
            $table->float('cliente')->nullable();
            $table->float('valor')->nullable();
            $table->float('igv')->nullable();
            $table->float('total')->nullable();
            $table->float('total_dolares')->nullable();
            $table->integer('tipopago_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->dateTime('fecha_pago')->nullable();
            $table->string('transferencia')->nullable();
            $table->string('ultimos_digitos')->nullable();
            $table->string('lote')->nullable();
            $table->float('monto_efectivo')->nullable();
            $table->float('monto_tarjeta')->nullable();
            $table->integer('moneda_id')->unsigned()->nullable();
            $table->integer('tipocambio_id')->unsigned()->nullable();
            $table->smallInteger('tipo')->nullable();
            $table->float('paciente_pago')->nullable();
            $table->float('disponible')->nullable();
            $table->float('vuelto')->nullable();
            $table->integer('indicador')->nullable();
            $table->float('disponible_efectivo')->nullable();
            $table->float('disponible_tarjeta')->nullable();
            $table->float('contable')->nullable();
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            $table->foreign('presupuestooperatoria_id')->references('id')->on('presupuestosoperatorias')->onDelete('cascade'); 
            $table->foreign('presupuestoortodoncia_id')->references('id')->on('presupuestosortodoncias')->onDelete('cascade');                         
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('empresapaciente_id')->references('id')->on('empresapacientes')->onDelete('cascade'); 
            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');                         
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');            
            $table->foreign('tipocambio_id')->references('id')->on('tipocambios')->onDelete('cascade');             
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
        Schema::dropIfExists('pagos');
    }
}
