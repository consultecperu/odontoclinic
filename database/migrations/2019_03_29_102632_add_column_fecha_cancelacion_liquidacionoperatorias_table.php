<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFechaCancelacionLiquidacionoperatoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('liquidacionoperatorias', function (Blueprint $table) {
            $table->dateTime('fecha_cancelacion')->nullable();
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
            $table->dropColumn('fecha_cancelacion');  
        });
    }
}
