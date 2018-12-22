<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Permiso extends Model
{
    protected $table = "permisos";

    protected $fillable = ['id', 'empleado_id', 'sede_id', 'fecha_inicio','fecha_fin','motivo','tipopermiso','horaini','horafin','lucro_cesante','user_id','estado','activo'];
    
    public function getFechaInicioAttribute($date){
        if(!is_null($date)){
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
        }
    }
    public function getFechaFinAttribute($date){
        if(!is_null($date)){
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
        }
    }    
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }
    public function sede()
    {
        return $this->belongsTo('App\Sede');
    } 
    public function _horaini()
    {
        return $this->belongsTo('App\Hora','horaini');
    }   
    public function _horafin()
    {
        return $this->belongsTo('App\Hora','horafin');
    }         
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
   
}
