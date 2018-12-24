<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pacientetitular_id')->unsigned();
            $table->integer('pacientedependiente_id')->unsigned();
            $table->integer('parentesco_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('pacientetitular_id')->references('id')->on('pacientes')->onDelete('cascade');              
            $table->foreign('pacientedependiente_id')->references('id')->on('pacientes')->onDelete('cascade');  
            $table->foreign('parentesco_id')->references('id')->on('parentescos')->onDelete('cascade');  
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');              
            $table->timestamps();
        });
        Schema::create('paciente_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->smallInteger('tipo')->default(1);
            $table->integer('plan_id')->unsigned()->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('empresapaciente_id')->unsigned()->nullable();
            $table->integer('poliza_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');              
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade');  
            $table->foreign('empresapaciente_id')->references('id')->on('empresapacientes')->onDelete('cascade');  
            $table->foreign('poliza_id')->references('id')->on('polizas')->onDelete('cascade');              
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');               
            $table->timestamps();
        });   
        Schema::create('paciente_multimedia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->string('nombre')->nullable();
            $table->string('archivo')->nullable();
            $table->smallInteger('tipo')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');              
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
        Schema::dropIfExists('dependientes');
    }
}
