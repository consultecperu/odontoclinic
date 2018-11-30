<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion')->unique();
            $table->string('abreviatura',10)->nullable();
            $table->string('ruc',13);
            $table->string('direccion')->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('facturar_a')->nullable();
            $table->text('comentario');
            $table->tinyInteger('principal')->default(1);
            $table->tinyInteger('tipo')->default(1);
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('facturacion_mltd')->default(0);
            $table->tinyInteger('descuento')->default(0);
            $table->boolean('activo')->default(true);            
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
        Schema::dropIfExists('planes');
    }
}
