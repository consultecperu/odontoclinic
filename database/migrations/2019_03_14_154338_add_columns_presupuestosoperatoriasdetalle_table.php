<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPresupuestosoperatoriasdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosoperatoriasdetalle', function (Blueprint $table) {
            $table->float('monto_efectivo')->nullable();
            $table->float('monto_tarjeta')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuestosoperatoriasdetalle', function (Blueprint $table) {
            $table->dropColumn('monto_efectivo');
            $table->dropColumn('monto_tarjeta');            
        });
    }
}
