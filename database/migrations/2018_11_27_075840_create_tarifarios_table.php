<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarifariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sede_id')->unsigned();
            $table->integer('servicio_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->integer('moneda_id')->unsigned();
            $table->float('costo',8,2);
            $table->integer('tipo')->default(1); // 1 aseguradora 2 particular
            $table->integer('solocoaseguro');
            $table->integer('cuotas')->nullable();
            $table->float('cuota_inicial')->nullable();
            $table->integer('ortodoncia')->nullable();
            $table->integer('user_id')->unsigned();
            $table->float('control_mensual')->nullable();
            $table->boolean('activo')->default(1);
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade'); 
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade'); 
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade'); 
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
        Schema::dropIfExists('tarifarios');
    }
}
