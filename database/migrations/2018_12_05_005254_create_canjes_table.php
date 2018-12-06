<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanjesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canjes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('motivo_canje')->nullable();
            $table->integer('genera_canje_a')->nullable();            
            $table->integer('tipo_canje')->nullable();
            $table->string('numero_certificado')->nullable(); 
            $table->integer('otorgar_a')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);   
            $table->foreign('user_id')->references('id')->on('users');              
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
        Schema::dropIfExists('canjes');
    }
}
