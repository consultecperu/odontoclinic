<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratoriotrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratoriotrabajos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuestooperatoriadetalle_id')->unsigned()->nullable();
            $table->integer('presupuestoortodonciadetalle_id')->unsigned()->nullable();
            $table->integer('servicio_id')->unsigned();
            $table->float('costo',8,2)->nullable();
            $table->datetime('fecha_separacion')->nullable();
            $table->datetime('fecha_envio')->nullable();
            $table->datetime('fecha_recepcion')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->datetime('fecha_liquidacion')->nullable();
            $table->smallInteger('seguimiento')->default(1);
            $table->integer('empleado_id')->unsigned();
            $table->integer('sede_id')->unsigned();
            $table->integer('laboratorioservicio_id')->unsigned();
            $table->integer('fase_id')->nullable();
            $table->smallInteger('liquidado')->default(0);
            $table->integer('tipo')->nullable();
            $table->integer('liquidable')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('presupuestooperatoriadetalle_id')->references('id')->on('presupuestosoperatoriasdetalle')->onDelete('cascade'); 
            $table->foreign('presupuestoortodonciadetalle_id')->references('id')->on('presupuestosortodonciasdetalle')->onDelete('cascade');                         
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade'); 
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            $table->foreign('laboratorioservicio_id')->references('id')->on('laboratorioservicios')->onDelete('cascade');
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
        Schema::dropIfExists('laboratoriotrabajos');
    }
}
