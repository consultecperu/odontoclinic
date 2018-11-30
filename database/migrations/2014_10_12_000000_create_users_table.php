<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('perfil_id')->unsigned();
            //$table->integer('personal_id')->unsigned();
            $table->boolean('acceso')->default(true);            
            $table->boolean('activo')->default(true);
            $table->date('fecha_vencimiento')->nullable();            
            $table->rememberToken();

            $table->foreign('perfil_id')->references('id')->on('perfiles')->onDelete('cascade'); 

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
        Schema::dropIfExists('users');
    }
}
