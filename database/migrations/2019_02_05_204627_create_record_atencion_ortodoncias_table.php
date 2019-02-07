<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordAtencionOrtodonciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recordatencionortodoncias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuestoortodonciadetalle_id')->unsigned()->nullable();
            $table->integer('fase_id')->nullable();
            $table->text('descripcion')->nullable();
            $table->smallInteger('realizado')->default(1);
            $table->text('comentario')->nullable();
            $table->integer('empleado_id')->unsigned()->nullable();
            $table->dateTime('fecha_realizacion')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('laboratorio_id')->unsigned()->nullable();
            $table->integer('material_id')->unsigned()->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('presupuestoortodonciadetalle_id')->references('id')->on('presupuestosortodonciasdetalle')->onDelete('cascade'); 
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');                         
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('cascade');            
            $table->foreign('material_id')->references('id')->on('materiales')->onDelete('cascade');             
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
        Schema::dropIfExists('recordatencionortodoncias');
    }
}
