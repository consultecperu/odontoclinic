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
    
}
