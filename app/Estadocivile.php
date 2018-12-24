<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadocivile extends Model
{
    protected $table = "estadociviles";

    protected $fillable = ['id', 'nombre_estadocivil', 'activo'];

    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }      
    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }       
}

