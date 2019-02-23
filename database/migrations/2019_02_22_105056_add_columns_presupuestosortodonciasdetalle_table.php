<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPresupuestosortodonciasdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestosortodonciasdetalle', function (Blueprint $table) {
            $table->integer('pago_id')->unsigned()->nullable();
            $table->smallInteger('liquidado')->default(0);
            $table->datetime('fecha_descarga')->nullable();
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
        Schema::table('presupuestosortodonciasdetalle', function (Blueprint $table) {
            $table->dropColumn('pago_id');
            $table->dropColumn('liquidado');
            $table->dropColumn('fecha_descarga');                        
        });
    }
}
