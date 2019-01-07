<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo',3)->nullable();
            $table->string('nombre_diente')->nullable();
            $table->integer('cuadrante')->nullable();
            $table->enum('tipo',['permanente','nino','mixta'])->default('permanente'); 
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
        Schema::dropIfExists('dientes');
    }
}
