<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPresupuestosoperatoriasdetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosoperatoriasdetalle', function (Blueprint $table) {
            $table->integer('pago_id')->unsigned()->nullable();
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('cascade');              
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
            $table->dropColumn('pago_id');
        });
    }
}
