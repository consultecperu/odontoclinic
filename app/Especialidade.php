<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $table = "especialidades";

    protected $fillable = ['id', 'nombre_especialidad','user_id','peso','activo'];

    public function empleados()
    {
        return $this->belongsToMany('App\Empleado')->withTimestamps();
    }      
}
