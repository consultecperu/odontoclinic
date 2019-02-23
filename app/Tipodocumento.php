<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodocumento extends Model
{
    protected $table = "tipodocumentos";

    protected $fillable = ['id', 'nombre_tipodocumento', 'abreviatura','tipo', 'activo'];

    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }  
    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }           
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }      
}
