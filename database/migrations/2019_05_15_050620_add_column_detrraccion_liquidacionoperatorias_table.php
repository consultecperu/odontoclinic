<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDetrraccionLiquidacionoperatoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('liquidacionoperatorias', function (Blueprint $table) {
            $table->float('monto_liquidable',8)->default(0);
            $table->float('detraccion',8)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('liquidacionoperatorias', function (Blueprint $table) {
            $table->dropColumn('monto_liquidable');
            $table->dropColumn('detraccion');
        });
    }
}
