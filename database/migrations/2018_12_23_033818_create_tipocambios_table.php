<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipocambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipocambios', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_registro')->nullable();
            $table->float('valor_compra')->nullable();
            $table->float('valor_venta')->nullable();
            $table->float('tipo_cambio')->nullable();
            $table->integer('monedade_id')->unsigned();
            $table->integer('monedaa_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default('true');             
            $table->foreign('monedade_id')->references('id')->on('monedas')->onDelete('cascade');  
            $table->foreign('monedaa_id')->references('id')->on('monedas')->onDelete('cascade');  
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
        Schema::dropIfExists('tipocambios');
    }
}
