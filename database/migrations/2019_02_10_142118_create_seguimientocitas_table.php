<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientocitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientocitas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cita_id')->unsigned();
            $table->dateTime('fecha_incidencia')->nullable();
            $table->date('fecha_anterior')->nullable();
            $table->date('fecha_nueva')->nullable();
            $table->string('start_anterior')->nullable();
            $table->string('end_anterior')->nullable();
            $table->string('start_nueva')->nullable();
            $table->string('end_nueva')->nullable();
            $table->integer('estadocita_id')->unsigned()->nullable();
            $table->integer('empleado_id')->unsigned()->nullable();
            $table->smallInteger('reprogramado')->default(0);
            $table->smallInteger('eliminado')->default(0);
            $table->text('comentario')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);

            $table->foreign('cita_id')->references('id')->on('citas')->onDelete('cascade');
            $table->foreign('estadocita_id')->references('id')->on('estadocitas')->onDelete('cascade');            
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');                                   
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
        Schema::dropIfExists('seguimientocitas');
    }
}
