<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnGruposervicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gruposervicios', function (Blueprint $table) {
            $table->tinyInteger('tipo')->default(1);    // 1 operatoria 2 ortodoncia
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gruposervicios', function (Blueprint $table) {
            $table->dropColumn('tipo');  
        });
    }
}
