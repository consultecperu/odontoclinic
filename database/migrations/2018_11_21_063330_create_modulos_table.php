<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->unique();
            $table->integer('idparent')->nullable();
            $table->enum('type',['module','menu','option']);
            $table->string('icono')->nullable();
            $table->string('name_router',100)->unique()->nullable();
            $table->string('name_template',100)->unique()->nullable();
            $table->integer('orden')->default(1);
            $table->boolean('active')->default(true);            
            $table->timestamps();
        });

        Schema::create('modulo_perfile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('perfile_id')->unsigned();
            $table->integer('modulo_id')->unsigned();           

            $table->foreign('perfile_id')->references('id')->on('perfiles');
            $table->foreign('modulo_id')->references('id')->on('modulos');

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
        Schema::dropIfExists('modulos');
    }
}
