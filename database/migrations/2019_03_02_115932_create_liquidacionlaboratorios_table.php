<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionlaboratoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionlaboratorios', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha_liquidacion')->nullable();
            $table->string('codigo',10)->nullable();
            $table->integer('tipodocumento_id')->unsigned()->nullable();
            $table->integer('laboratorio_id')->unsigned();
            $table->integer('sede_id')->unsigned();
            $table->string('serie',10)->nullable();
            $table->string('numero',20)->nullable();
            $table->float('monto',8,2)->nullable();
            $table->integer('moneda_id')->unsigned();
            $table->smallInteger('pagado')->default(0);
            $table->text('comentario')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos')->onDelete('cascade'); 
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('cascade');                         
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');
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
        Schema::dropIfExists('liquidacionlaboratorios');
    }
}
