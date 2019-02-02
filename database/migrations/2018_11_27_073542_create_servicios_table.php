<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_servicio')->unique();
            $table->integer('user_id')->unsigned();
            $table->integer('simbologia_id')->unsigned()->nullable();
            $table->integer('tipo')->default(1);    // 1 operatoria 2 ortodoncia
            $table->integer('parentid_ortodoncia')->nullable();
            $table->boolean('activo')->default(true);   
            $table->foreign('simbologia_id')->references('id')->on('simbologias')->onDelete('cascade');       
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');                                        
            $table->timestamps();        
        });

        Schema::create('servicio_gruposervicio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gruposervicio_id')->unsigned();
            $table->integer('servicio_id')->unsigned();           

            $table->foreign('gruposervicio_id')->references('id')->on('gruposervicios');
            $table->foreign('servicio_id')->references('id')->on('servicios');

            $table->timestamps();
        });   

        Schema::create('servicio_laboratorio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('laboratorio_id')->unsigned();
            $table->integer('servicio_id')->unsigned();           

            $table->foreign('laboratorio_id')->references('id')->on('laboratorios');
            $table->foreign('servicio_id')->references('id')->on('servicios');

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
        Schema::dropIfExists('servicios');
    }
}
