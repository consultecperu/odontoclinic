<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipocontrato extends Model
{
    protected $table = "tipocontratos";

    protected $fillable = ['id', 'nombre_tipocontrato', 'activo'];

    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }      
}
