<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSaldolabPresupuestosoperatoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosoperatorias', function (Blueprint $table) {
            $table->float('saldo_lab')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuestosoperatorias', function (Blueprint $table) {
            $table->dropColumn('saldo_lab');
        });
    }
}
