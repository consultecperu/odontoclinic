<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresapaciente_id')->unsigned();
            $table->string('contacto')->nullable();
            $table->integer('user_id')->unsigned();
            $table->smallInteger('vigencia')->default(1);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_finalizacion')->nullable(); 
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->boolean('activo')->default(true);   
            $table->foreign('empresapaciente_id')->references('id')->on('empresapacientes');
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
        Schema::dropIfExists('convenios');
    }
}
