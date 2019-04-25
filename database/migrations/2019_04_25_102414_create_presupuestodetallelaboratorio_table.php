<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestodetallelaboratorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestodetallelaboratorio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuestooperatoriadetalle_id')->unsigned()->nullable();
            $table->integer('presupuestoortodonciadetalle_id')->unsigned()->nullable();
            $table->integer('laboratorio_id')->unsigned()->nullable();
            $table->float('monto')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuestodetallelaboratorio');
    }
}
