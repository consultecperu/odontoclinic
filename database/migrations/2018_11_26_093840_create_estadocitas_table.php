<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadocitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadocitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_estadocita')->unique();
            $table->integer('orden');
            $table->string('color');
            $table->string('color_disabled');
            $table->string('color_font');
            $table->string('color_border');
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
        Schema::dropIfExists('estadocitas');
    }
}
