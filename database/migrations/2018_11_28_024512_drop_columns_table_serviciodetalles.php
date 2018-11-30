<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsTableServiciodetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serviciodetalles', function (Blueprint $table) {
            $table->dropColumn('laboratorio'); 
            $table->dropColumn('material');             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serviciodetalles', function (Blueprint $table) {
            $table->tinyInteger('laboratorio')->default(0);
            $table->tinyInteger('material')->default(0);   
        });
    }
}
