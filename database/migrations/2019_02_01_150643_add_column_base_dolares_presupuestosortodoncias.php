<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnBaseDolaresPresupuestosortodoncias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosortodoncias', function (Blueprint $table) {
            $table->float('cuota_inicial_base_dolares',8,2)->nullable();
            $table->float('control_mensual_base_dolares',8,2)->nullable();      
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
            $table->dropColumn('cuota_inicial_base_dolares');
            $table->dropColumn('control_mensual_base_dolares');     
        });
    }
}
