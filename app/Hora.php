<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table = "horas";

    protected $fillable = ['id', 'nombre_hora', 'turno','activo'];    

    public function turnos()
    {
        return $this->hasMany('App\Turno');
    }   
    public function turnosespeciales()
    {
        return $this->hasMany('App\TurnoEspecial');
    } 
    public function permisos()
    {
        return $this->hasMany('App\Permiso');
    }              

}
