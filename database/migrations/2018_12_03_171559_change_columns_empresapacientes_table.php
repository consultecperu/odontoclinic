<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsEmpresapacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresapacientes', function (Blueprint $table) {
            $table->string('direccion')->nullable()->change();
            $table->string('telefono')->nullable()->change();
            $table->string('celular')->nullable()->change();
            $table->string('codigo')->nullable()->change();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresapacientes', function (Blueprint $table) {
            //
        });
    }
}
