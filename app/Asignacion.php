<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = "asignaciones";

    protected $fillable = ['id', 'nombre_asignacion', 'activo'];

    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }         
    
}
