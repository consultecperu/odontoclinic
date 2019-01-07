<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDerivacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derivaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->integer('empleadoderivante_id')->unsigned();
            $table->integer('empleadoderivado_id')->unsigned();
            $table->text('motivo')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('servicio_id')->unsigned();
            $table->smallInteger('indicador')->default(1);
            $table->date('fecha_registro')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');              
            $table->foreign('empleadoderivante_id')->references('id')->on('empleados')->onDelete('cascade');  
            $table->foreign('empleadoderivado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');               
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
        Schema::dropIfExists('derivaciones');
    }
}
