<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientoplanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientoplanes', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha')->nullable();
            $table->integer('paciente_id')->unsigned();
            $table->smallInteger('tipo')->default(1);
            $table->integer('plan_id')->unsigned();
            $table->integer('empresapaciente_id')->unsigned()->nullable();
            $table->integer('poliza_id')->unisigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);

            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');  
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade');  
            $table->foreign('empresapaciente_id')->references('id')->on('empresapacientes')->onDelete('cascade');  
            $table->foreign('poliza_id')->references('id')->on('polizas')->onDelete('cascade');  
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
        Schema::dropIfExists('seguimientoplanes');
    }
}
