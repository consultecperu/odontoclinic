<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionortodonciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionortodoncias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado_id')->unsigned();
            $table->integer('sede_id')->unsigned();
            $table->datetime('fecha_corte')->nullable();
            $table->float('monto_total_atenciones')->nullable();
            $table->float('monto_total_abonos')->nullable();
            $table->float('monto_total_descuentos')->nullable();
            $table->float('monto_total_liquidar')->nullable();
            $table->text('motivo_eliminacion')->nullable();
            $table->smallInteger('tipo')->default(1);
            $table->integer('moneda_id')->unsigned();
            $table->smallInteger('pagado')->default(0);
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');                         
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
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
        Schema::dropIfExists('liquidacionortodoncias');
    }
}
