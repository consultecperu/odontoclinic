<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarifario extends Model
{
    protected $table = "tarifarios";

    protected $fillable = ['id', 'sede_id', 'servicio_id','plan_id','moneda_id','costo','tipo','solocoaseguro','cuotas','cuota_inicial','ortodoncia', 'user_id','control_mensual','tarifa', 'activo'];
    
    public function sede()
    {
    	return $this->belongsTo('App\Sede');
    } 
    public function servicio()
    {
    	return $this->belongsTo('App\Servicio');
    }    
    public function plan()
    {
    	return $this->belongsTo('App\Plane');
    }   
    public function moneda()
    {
    	return $this->belongsTo('App\Moneda');
    } 
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\Presupuestooperatoriadetalle');
    } 
    public function presupuestosortodoncias()
    {
        return $this->hasMany('App\Presupuestoortodoncia');
    }          
    public function user()
    {
    	return $this->belongsTo('App\User');
    }            
}
