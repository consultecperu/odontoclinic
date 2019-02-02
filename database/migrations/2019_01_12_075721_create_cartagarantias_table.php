<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartagarantiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartagarantias', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('tipo')->default(1);
            $table->integer('presupuestooperatoria_id')->unsigned()->nullable();
            $table->integer('presupuestoortodoncia_id')->unsigned()->nullable();            
            $table->string('numero',20)->nullable();
            $table->float('monto',8,2)->nullable();
            $table->integer('empresapaciente_id')->unsigned();
            $table->float('psaldo',8,2)->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('presupuestooperatoria_id')->references('id')->on('presupuestosoperatorias')->onDelete('cascade'); 
            $table->foreign('presupuestoortodoncia_id')->references('id')->on('presupuestosortodoncias')->onDelete('cascade'); 
            $table->foreign('empresapaciente_id')->references('id')->on('empresapacientes')->onDelete('cascade');             
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
        Schema::dropIfExists('cartagarantias');
    }
}
