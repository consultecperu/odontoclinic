<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->string('nombre_completo')->nullable();

            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos');
            $table->foreign('ubigeo_id')->references('id')->on('ubigeos');
            $table->foreign('tipocontrato_id')->references('id')->on('tipocontratos');
            $table->foreign('useracceso_id')->references('id')->on('users');  
            $table->foreign('estadocivil_id')->references('id')->on('estadociviles');  
            $table->foreign('tipopagodoctor_id')->references('id')->on('tipopagodoctores');  
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->foreign('user_id')->references('id')->on('users');                                                                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->dropColumn('nombre_completo');
        });
    }
}
