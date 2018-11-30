<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciodetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviciodetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servicio_id')->unsigned();
            $table->integer('control_ortodoncia');
            $table->integer('cuota_inicial');
            $table->integer('material');
            $table->integer('laboratorio');
            $table->integer('exodoncia');
            $table->integer('ortofacil');
            $table->boolean('activo');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');              
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
        Schema::dropIfExists('serviciodetalles');
    }
}
