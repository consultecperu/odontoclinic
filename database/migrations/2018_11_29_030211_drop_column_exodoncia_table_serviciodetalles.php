<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnExodonciaTableServiciodetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serviciodetalles', function (Blueprint $table) {
            $table->dropColumn('exodoncia'); 
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
            $table->tinyInteger('exodoncia')->default(0);
        });
    }
}
