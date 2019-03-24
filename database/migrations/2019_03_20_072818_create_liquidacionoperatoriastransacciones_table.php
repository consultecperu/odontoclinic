<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionoperatoriastransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionoperatoriastransacciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('liquidacionoperatoria_id')->unsigned();
            $table->integer('transacciondoctor_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('liquidacionoperatoria_id')->references('id')->on('liquidacionoperatorias')->onDelete('cascade');                         
            $table->foreign('transacciondoctor_id')->references('id')->on('transaccionesdoctor')->onDelete('cascade');            
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
        Schema::dropIfExists('liquidacionoperatoriastransacciones');
    }
}
