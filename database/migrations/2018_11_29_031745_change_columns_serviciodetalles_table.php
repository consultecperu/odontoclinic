<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsServiciodetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serviciodetalles', function (Blueprint $table) {
            $table->smallInteger('control_ortodoncia')->default(0)->change();
            $table->smallInteger('cuota_inicial')->default(0)->change();  
            $table->smallInteger('ortofacil')->default(0)->change();                     
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
            //
        });
    }
}
