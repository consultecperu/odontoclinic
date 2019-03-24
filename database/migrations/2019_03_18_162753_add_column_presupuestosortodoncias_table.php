<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPresupuestosortodonciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosortodoncias', function (Blueprint $table) {
            $table->float('saldo_tarjeta')->nullable();
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
            $table->dropColumn('saldo_tarjeta');
        });
    }
}
