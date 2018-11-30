<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_sede');
            $table->integer('ubigeo_id')->unsigned();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('telef_adicional')->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('correo')->nullable();
            $table->string('codigo')->nullable();
            $table->boolean('activo')->default(true);            
            $table->foreign('ubigeo_id')->references('id')->on('ubigeos')->onDelete('cascade');
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
        Schema::dropIfExists('sedes');
    }
}
