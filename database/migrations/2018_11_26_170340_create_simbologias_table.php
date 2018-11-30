<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimbologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simbologias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_simbologia')->unique();
            $table->string('imagen_rojo');
            $table->string('tipo');
            $table->string('imagen');
            $table->string('imagen_azul');
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('simbologias');
    }
}
