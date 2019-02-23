<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguimientocita extends Model
{
    protected $table = "seguimientocitas";

    protected $fillable = ['id', 'cita_id','fecha_incidencia','fecha_anterior','fecha_nueva','start_anterior','end_anterior','start_nueva','end_nueva','estadocita_id','empleado_id','reprogramado','eliminado','comentario','user_id', 'activo'];
    
    public function cita()
    {
    	return $this->belongsTo('App\Cita');
    } 
    public function estadocita()
    {
    	return $this->belongsTo('App\Estadocita');
    } 
    public function empleado()
    {
    	return $this->belongsTo('App\Empleado');
    }         
    public function user()
    {
    	return $this->belongsTo('App\User');
    }  
}
