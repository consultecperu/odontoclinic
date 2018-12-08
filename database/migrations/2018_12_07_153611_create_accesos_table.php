<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('key',6)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('acceso_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('acceso_id')->unsigned();
            $table->integer('user_id')->unsigned();   
            $table->boolean('crear')->default(false);
            $table->boolean('actualizar')->default(false);   
            $table->boolean('eliminar')->default(false);   
            $table->boolean('ver')->default(false);   
            $table->boolean('autorizar')->default(false);   
            $table->boolean('activo')->default(true);                                                                              
            $table->foreign('acceso_id')->references('id')->on('accesos');
            $table->foreign('user_id')->references('id')->on('users');          
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
        Schema::dropIfExists('accesos');
        Schema::dropIfExists('acceso_usuario');
    }
}
