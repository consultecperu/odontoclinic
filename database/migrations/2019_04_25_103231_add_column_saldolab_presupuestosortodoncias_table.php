<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSaldolabPresupuestosortodonciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosortodoncias', function (Blueprint $table) {
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
        Schema::table('presupuestosortodoncias', function (Blueprint $table) {
            $table->dropColumn('saldo_lab');
        });
    }
}
