<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->date('fecha_cita')->nullable();
            $table->integer('sede_id')->unsigned();
            $table->smallInteger('adicional')->default(0);
            $table->smallInteger('tipo')->default(1);
            $table->smallInteger('fuera_hora')->default(0);
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);

            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');                         
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
        Schema::dropIfExists('citas');
    }
}
