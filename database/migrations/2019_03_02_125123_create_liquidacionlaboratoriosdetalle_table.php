<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionlaboratoriosdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionlaboratoriosdetalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('liquidacionlaboratorio_id')->unsigned();
            $table->integer('laboratoriotrabajo_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('liquidacionlaboratorio_id')->references('id')->on('liquidacionlaboratorios')->onDelete('cascade');                         
            $table->foreign('laboratoriotrabajo_id')->references('id')->on('laboratoriotrabajos')->onDelete('cascade');
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
        Schema::dropIfExists('liquidacionlaboratoriosdetalle');
    }
}
