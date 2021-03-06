<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipocontratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipocontratos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_tipocontrato')->unique();
            $table->integer('user_id')->nullable()->unsigned();
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('tipocontratos');
    }
}
