<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLadosPresupuestosoperatoriasdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosoperatoriasdetalle', function (Blueprint $table) {
            $table->string('lados',5)->nullable();
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
            $table->dropColumn('lados');
        });
    }
}
