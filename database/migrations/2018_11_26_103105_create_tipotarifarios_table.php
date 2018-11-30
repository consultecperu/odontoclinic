<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipotarifariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipotarifarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_tipotarifario')->unique();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('tipotarifarios');
    }
}
