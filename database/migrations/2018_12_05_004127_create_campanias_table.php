<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresapaciente_id')->unsigned();
            $table->string('nombre_campania')->nullable();
            $table->string('lugar')->nullable();            
            $table->date('fecha_realizacion')->nullable();
            $table->date('fecha_vencimiento')->nullable(); 
            $table->string('contacto')->nullable();
            $table->smallInteger('vigencia')->default(1);
            $table->string('telefono')->nullable();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('campanias');
    }
}
