<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = "ubigeos";

    protected $fillable = ['id', 'coddepa','codprov','coddist','descripcion','activo'];

    public function sedes()
    {
    	return $this->hasMany('App\Sede');
    } 
    public function empresapacientes()
    {
    	return $this->hasMany('App\Empresapaciente');
    } 
    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }          
}
