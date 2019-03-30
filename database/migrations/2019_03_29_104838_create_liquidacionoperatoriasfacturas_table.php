<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionoperatoriasfacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionoperatoriasfacturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('liquidacionoperatoria_id')->unsigned();
            $table->integer('tipodocumento_id')->unsigned()->nullable();
            $table->string('serie',10)->nullable();
            $table->string('numero',20)->nullable();
            $table->float('monto',8)->nullable();
            $table->boolean('activo')->default(true);

            $table->foreign('liquidacionoperatoria_id')->references('id')->on('liquidacionoperatorias')->onDelete('cascade');  
            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos')->onDelete('cascade');  
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
        Schema::dropIfExists('liquidacionoperatoriasfacturas');
    }
}
