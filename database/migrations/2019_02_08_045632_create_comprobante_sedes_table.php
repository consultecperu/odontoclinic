<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprobanteSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantesedes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipodocumento_id')->unsigned();
            $table->integer('sede_id')->unsigned();
            $table->integer('ptoventa');
            $table->string('serie')->nullable();
            $table->integer('correlativo')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos')->onDelete('cascade');
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');  
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
        Schema::dropIfExists('comprobantesedes');
    }
}
