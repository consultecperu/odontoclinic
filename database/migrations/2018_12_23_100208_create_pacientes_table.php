<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipodocumento_id')->unsigned();
            $table->string('numero_documento',9)->nullable();
            $table->integer('sede_id')->unsigned();
            $table->string('nombres')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo',['H','M'])->default('H');
            $table->integer('ubigeo_id')->unsigned()->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono',8)->nullable();
            $table->string('celular',9)->nullable();
            $table->string('email')->nullable();
            $table->integer('estadocivil_id')->unsigned()->nullable();
            $table->integer('motivocaptacion_id')->unsigned()->nullable();
            $table->string('telefono_mensajeria')->nullable();
            $table->smallInteger('titular')->default(1);
            $table->string('mensajeria')->nullable();
            $table->string('foto')->nullable();
            $table->integer('condicion_id')->unsigned()->nullable();
            $table->integer('empleado_id')->unsigned();
            $table->integer('asignacion_id')->unsigned();
            $table->date('fecha_ingreso')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('carnet',100)->nullable();
            $table->integer('convenio_id')->unsigned()->nullable();
            $table->integer('campania_id')->unsigned()->nullable();
            $table->integer('historiaclinica_id')->unsigned()->nullable();
            $table->text('observacion')->nullable();
            $table->string('apoderado')->nullable();
            $table->integer('parentesco_apoderado_id')->unsigned()->nullable();
            $table->integer('historial')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('activo')->default(true);            

            $table->foreign('tipodocumento_id')->references('id')->on('tipodocumentos')->onDelete('cascade');              
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');  
            $table->foreign('ubigeo_id')->references('id')->on('ubigeos')->onDelete('cascade');  
            $table->foreign('estadocivil_id')->references('id')->on('estadociviles')->onDelete('cascade');              
            $table->foreign('motivocaptacion_id')->references('id')->on('motivocaptaciones')->onDelete('cascade');  
            $table->foreign('condicion_id')->references('id')->on('condiciones')->onDelete('cascade'); 
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');  
            $table->foreign('asignacion_id')->references('id')->on('asignaciones')->onDelete('cascade');  
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');              
            $table->foreign('campania_id')->references('id')->on('campanias')->onDelete('cascade');  
            $table->foreign('historiaclinica_id')->references('id')->on('historiaclinicas')->onDelete('cascade');                                                   
            $table->foreign('parentesco_apoderado_id')->references('id')->on('parentescos')->onDelete('cascade');  
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
        Schema::dropIfExists('Pacientes');
    }
}
