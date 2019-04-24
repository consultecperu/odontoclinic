<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarasColumnsDientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dientes', function (Blueprint $table) {
            $table->string('cara_1')->nullable();
            $table->string('cara_2')->nullable();
            $table->string('cara_3')->nullable();
            $table->string('cara_4')->nullable();
            $table->string('cara_5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dientes', function (Blueprint $table) {
            $table->dropColumn('cara_1');
            $table->dropColumn('cara_2');
            $table->dropColumn('cara_3');
            $table->dropColumn('cara_4');
            $table->dropColumn('cara_5');
        });
    }
}
