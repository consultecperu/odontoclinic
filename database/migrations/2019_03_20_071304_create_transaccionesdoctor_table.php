<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionesdoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccionesdoctor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleado_id')->unsigned();
            $table->integer('sede_id')->unsigned();   
            $table->integer('moneda_id')->unsigned();                     
            $table->integer('concepto_id')->unsigned();
            $table->datetime('fecha')->nullable();
            $table->text('descripcion')->nullable();
            $table->float('total')->nullable();
            $table->smallInteger('ind_liquidacion')->nullable();
            $table->integer('liquidacionoperatoria_id')->unsigned()->nullable();
            $table->integer('liquidacionortodoncia_id')->unsigned()->nullable();
            $table->smallInteger('liquidado')->default(0);
            $table->smallInteger('origen')->nullable();
            $table->integer('user_id')->unsigned();            
            $table->boolean('activo')->default(true);
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');                         
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');  
            $table->foreign('concepto_id')->references('id')->on('conceptos')->onDelete('cascade');  
            $table->foreign('liquidacionoperatoria_id')->references('id')->on('liquidacionoperatorias')->onDelete('cascade');                         
            $table->foreign('liquidacionortodoncia_id')->references('id')->on('liquidacionortodoncias')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
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
        Schema::dropIfExists('transaccionesdoctor');
    }
}
