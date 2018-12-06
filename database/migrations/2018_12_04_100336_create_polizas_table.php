<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolizasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polizas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->date('vigencia_del')->nullable();
            $table->date('vigencia_al')->nullable();
            $table->integer('moneda_id')->unsigned();
            $table->float('deducible',8,2)->nullable();
            $table->float('coaseguro',8,2)->nullable();
            $table->text('comentario');
            $table->integer('user_id')->unsigned();
            $table->integer('planpoliza_id')->unsigned();
            $table->integer('empresapaciente_id')->unsigned();
            $table->integer('plane_id')->unsigned(0);
            $table->boolean('activo')->default(true);            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');
            $table->foreign('planpoliza_id')->references('id')->on('planpolizas')->onDelete('cascade'); 
            $table->foreign('empresapaciente_id')->references('id')->on('empresapacientes')->onDelete('cascade');                             
            $table->foreign('plane_id')->references('id')->on('planes')->onDelete('cascade'); 
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
        Schema::dropIfExists('polizas');
    }
}
