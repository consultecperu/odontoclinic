<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionlaboratoriosfacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionlaboratoriosfacturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('liquidacionlaboratorio_id')->unsigned();
            $table->string('serie',10)->nullable();
            $table->string('numero',20)->nullable();
            $table->float('monto',8)->nullable();
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
        Schema::dropIfExists('liquidacionlaboratoriosfacturas');
    }
}
