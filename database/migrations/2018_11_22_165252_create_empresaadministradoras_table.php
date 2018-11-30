<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaadministradorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresaadministradoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_empresa');
            $table->string('ruc',11)->nullable();
            $table->string('telefono')->nullable();            
            $table->string('email')->nullable();            
            $table->string('celular')->nullable();            
            $table->string('telef_adicional')->nullable();            
            $table->string('direccion')->nullable();
            $table->string('representante_legal')->nullable();            
            $table->string('logo')->nullable();    
            $table->integer('ubigeo_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);        
            $table->foreign('ubigeo_id')->references('id')->on('ubigeos')->onDelete('cascade');
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
        Schema::dropIfExists('empresaadministradoras');
    }
}
