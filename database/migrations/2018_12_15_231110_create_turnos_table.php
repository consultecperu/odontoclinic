<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado_id')->unsigned();
            $table->integer('dia_id')->unsigned();
            $table->integer('horaini1')->nullable()->unsigned();
            $table->integer('horafin1')->nullable()->unsigned();
            $table->integer('horaini2')->nullable()->unsigned();
            $table->integer('horafin2')->nullable()->unsigned();
            $table->integer('sede_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');              
            $table->foreign('dia_id')->references('id')->on('dias')->onDelete('cascade');  
            $table->foreign('horaini1')->references('id')->on('horas')->onDelete('cascade');   
            $table->foreign('horafin1')->references('id')->on('horas')->onDelete('cascade');  
            $table->foreign('horaini2')->references('id')->on('horas')->onDelete('cascade');  
            $table->foreign('horafin2')->references('id')->on('horas')->onDelete('cascade');  
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
        Schema::dropIfExists('turnos');
    }
}
