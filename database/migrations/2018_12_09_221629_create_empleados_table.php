<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipodocumento_id')->unsigned();
            $table->string('numero_documento',9)->nullable()->unique();
            $table->string('nombres',100)->nullable();
            $table->string('apellido_paterno',100)->nullable();
            $table->string('apellido_materno',100)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo',['H','M'])->default('H');
            $table->string('direccion')->nullable();
            $table->string('telefono',8)->nullable();
            $table->string('celular',9)->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->integer('ubigeo_id')->nullable()->unsigned();
            $table->string('COP')->nullable();
            $table->string('nconsultorio')->nullable();
            $table->integer('tipocontrato_id')->nullable()->unsigned();
            $table->integer('useracceso_id')->nullable()->unsigned();
            $table->integer('estadocivil_id')->nullable()->unsigned();
            $table->integer('tipopagodoctor_id')->nullable()->unsigned();
            $table->float('porcentaje_interno')->nullable();
            $table->float('porcentaje_aseguradora')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->integer('cargo_id')->nullable()->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo')->default(true);            
            $table->timestamps();
        });

        Schema::create('empleado_especialidad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('especialidade_id')->unsigned();
            $table->integer('empleado_id')->unsigned();           

            $table->foreign('especialidade_id')->references('id')->on('especialidades');
            $table->foreign('empleado_id')->references('id')->on('empleados');

            $table->timestamps();
        });   

        Schema::create('empleado_sede', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sede_id')->unsigned();
            $table->integer('empleado_id')->unsigned();           

            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('empleado_id')->references('id')->on('empleados');

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
        Schema::dropIfExists('empleados');
    }
}
