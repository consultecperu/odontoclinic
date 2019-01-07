<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Derivacion extends Model
{
    protected $table = "derivaciones";

    protected $fillable = ['id', 'paciente_id','empleadoderivante_id','empleadoderivado_id','motivo','user_id','servicio_id','indicador','fecha_registro','activo'];

    public function getFechaRegistroAttribute($date){
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
    }  
    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }
    public function empleadoderivante()
    {
        return $this->belongsTo('App\Empleado','empleadoderivante_id');
    } 
    public function empleadoderivado()
    {
        return $this->belongsTo('App\Empleado','empleadoderivado_id');
    } 
    public function user()
    {
    	return $this->belongsTo('App\User');
    }       
    public function servicio()
    {
    	return $this->belongsTo('App\Servicio');
    }         
}
