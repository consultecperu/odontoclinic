<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionoperatoriasdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionoperatoriasdetalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('liquidacionoperatoria_id')->unsigned();
            $table->integer('presupuestooperatoriadetalle_id')->unsigned();
            $table->integer('comision')->nullable();
            $table->float('comision_tarjeta')->nullable();
            $table->smallInteger('tipo_pago')->nullable();
            $table->float('sunat')->nullable();
            $table->float('laboratorio')->nullable();
            $table->float('material_doctor')->nullable();
            $table->float('material_proveedor')->nullable();
            $table->float('neto')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('liquidacionoperatoria_id')->references('id')->on('liquidacionoperatorias')->onDelete('cascade');                         
            $table->foreign('presupuestooperatoriadetalle_id')->references('id')->on('presupuestosoperatoriasdetalle')->onDelete('cascade');
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
        Schema::dropIfExists('liquidacionoperatoriasdetalle');
    }
}
