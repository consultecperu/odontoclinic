<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionortodonciasdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionortodonciasdetalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('liquidacionortodoncia_id')->unsigned();
            $table->integer('presupuestoortodonciadetalle_id')->unsigned();
            $table->integer('comision')->nullable();
            $table->float('comision_tarjeta')->nullable();
            $table->smallInteger('tipo_pago')->nullable();
            $table->float('sunat')->nullable();
            $table->float('laboratorio')->nullable();
            $table->float('material_doctor')->nullable();
            $table->float('material_proveedor')->nullable();
            $table->float('neto')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('liquidacionortodoncia_id')->references('id')->on('liquidacionortodoncias')->onDelete('cascade');                         
            $table->foreign('presupuestoortodonciadetalle_id')->references('id')->on('presupuestosortodonciasdetalle')->onDelete('cascade');
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
        Schema::dropIfExists('liquidacionortodonciasdetalle');
    }
}
