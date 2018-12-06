<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsDescuentoPlanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->smallInteger('facturacion_mltd')->nullable()->default(0)->change();
            $table->smallInteger('descuento')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planes', function (Blueprint $table) {
            //
        });
    }
}
