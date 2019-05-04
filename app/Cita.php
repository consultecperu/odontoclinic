<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cita extends Model
{
    protected $table = "citas";

    protected $fillable = ['id', 'paciente_id','empleado_id','start','end','fecha_cita','sede_id','adicional','tipo','fuera_hora','user_id','estadocita_id','activo'];
    
    public function getFechaCitaAttribute($date){
        return Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');   //formateo de la fecha para verlo en el frontend
    }    
    public function paciente()
    {
    	return $this->belongsTo('App\Paciente');
    } 
    public function empleado()
    {
    	return $this->belongsTo('App\Empleado');
    } 
    public function sede()
    {
    	return $this->belongsTo('App\Sede');
    }   
    public function estadocita()
    {
    	return $this->belongsTo('App\Estadocita');
    }           
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function seguimientocitas()
    {
        return $this->hasMany('App\Seguimientocita');
    }    
}
