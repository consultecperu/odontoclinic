<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnLaboratorioIdServicioLaboratorio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicio_laboratorio', function (Blueprint $table) {
            $table->dropForeign('servicio_laboratorio_laboratorio_id_foreign');
            $table->renameColumn('laboratorio_id', 'laboratorioservicio_id');
            $table->foreign('laboratorioservicio_id')->references('id')->on('laboratorioservicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicio_laboratorio', function (Blueprint $table) {
            //
        });
    }
}
