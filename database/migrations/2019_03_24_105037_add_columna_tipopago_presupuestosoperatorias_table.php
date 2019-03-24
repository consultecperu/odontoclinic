<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnaTipopagoPresupuestosoperatoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosoperatorias', function (Blueprint $table) {
            $table->integer('tipopago_id')->unsigned()->nullable();
            $table->foreign('tipopago_id')->references('id')->on('tipopagos')->onDelete('cascade');                         
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
            $table->dropColumn('tipopago_id');
        });
    }
}