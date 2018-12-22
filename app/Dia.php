<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    protected $table = "dias";

    protected $fillable = ['id', 'nombre_dia', 'valor', 'activo'];

    public function turnos()
    {
        return $this->hasMany('App\Turno');
    }         
}
