<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipopagodoctore extends Model
{
    protected $table = "tipopagodoctores";

    protected $fillable = ['id', 'nombre_tipopagodoctor', 'user_id', 'activo'];

    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }     
}
