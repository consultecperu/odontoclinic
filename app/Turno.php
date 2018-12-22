<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = "turnos";

    protected $fillable = ['id', 'empleado_id','dia_id','horaini1','horafin1','horaini2','horafin2','sede_id','user_id','activo'];

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }  
    public function dia()
    {
        return $this->belongsTo('App\Dia');
    }
    public function horaini1()
    {
        return $this->belongsTo('App\Hora','horaini1');
    }   
    public function horafin1()
    {
        return $this->belongsTo('App\Hora','horafin1');
    }   
    public function horaini2()
    {
        return $this->belongsTo('App\Hora','horaini2');
    }   
    public function horafin2()
    {
        return $this->belongsTo('App\Hora','horafin2');
    }    
    public function sede()
    {
    	return $this->belongsTo('App\Sede');
    }                 
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
  
}
