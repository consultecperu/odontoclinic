<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLiquidacionlaboratoriosfacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('liquidacionlaboratoriosfacturas', function (Blueprint $table) {
            $table->integer('tipodocumento_id')->unsigned()->nullable();
            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('liquidacionlaboratoriosfacturas', function (Blueprint $table) {
            $table->dropColumn('tipodocumento_id');
        });
    }
}
