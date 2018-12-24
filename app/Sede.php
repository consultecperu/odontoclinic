<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = "sedes";

    protected $fillable = ['id', 'nombre_sede', 'ubigeo_id', 'direccion','telefono','celular','telef_adicional','correo','codigo','user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function ubigeo()
    {
    	return $this->belongsTo('App\Ubigeo');
    }      
    public function tarifarios()
    {
        return $this->hasMany('App\Tarifario');
    }
    public function empleados()
    {
        return $this->belongsToMany('App\Empleado')->withTimestamps();
    }  
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
    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }  
    public function historiaclinicas()
    {
        return $this->hasMany('App\Historiaclinica');
    }                            
}
