<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRucLaboratoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laboratorios', function (Blueprint $table) {
            $table->string('ruc',11)->nullable();
            $table->string('razon_social')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laboratorios', function (Blueprint $table) {
            $table->dropColumn('ruc');
            $table->dropColumn('razon_social');
        });
    }
}
