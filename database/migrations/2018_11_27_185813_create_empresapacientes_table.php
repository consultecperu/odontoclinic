<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresapacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresapacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ruc',11);
            $table->string('razon_social')->unique();
            $table->integer('ubigeo_id')->unsigned()->nullable();
            $table->string('direccion');
            $table->string('telefono');
            $table->string('celular',9);
            $table->integer('user_id')->unsigned();
            $table->string('codigo');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('empresapaciente_plane', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresapaciente_id')->unsigned();
            $table->integer('plane_id')->unsigned();           

            $table->foreign('empresapaciente_id')->references('id')->on('empresapacientes');
            $table->foreign('plane_id')->references('id')->on('planes');

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
        Schema::dropIfExists('empresapacientes');
    }
}
