<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado_id')->unsigned();
            $table->integer('sede_id')->unsigned();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('motivo')->nullable();
            $table->integer('tipopermiso')->default(1);
            $table->integer('horaini')->unsigned()->nullable();
            $table->integer('horafin')->unsigned()->nullable();
            $table->boolean('lucro_cesante')->default(false);
            $table->integer('user_id')->unsigned();
            $table->boolean('estado')->default(true);
            $table->boolean('activo')->default(true);   
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade'); 
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');              
            $table->foreign('horaini')->references('id')->on('horas')->onDelete('cascade');  
            $table->foreign('horafin')->references('id')->on('horas')->onDelete('cascade');  
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
        Schema::dropIfExists('permisos');
    }
}
