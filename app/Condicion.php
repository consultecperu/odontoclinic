<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    protected $table = "condiciones";

    protected $fillable = ['id', 'nombre_condicion', 'activo'];

    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }     
    
}
