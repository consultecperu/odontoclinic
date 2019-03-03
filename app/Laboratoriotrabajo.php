<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Laboratoriotrabajo extends Model
{
    protected $table = "laboratoriotrabajos";

    protected $fillable = ['id', 'presupuestooperatoriadetalle_id','presupuestoortodonciadetalle_id','servicio_id','costo','fecha_separacion','fecha_envio','fecha_recepcion','fecha_entrega','fecha_liquidacion','seguimiento','empleado_id','sede_id','laboratorioservicio_id','fase_id','liquidado','tipo','liquidable','user_id','activo'];
    
    public function getFechaSeparacionAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    }
/*     public function getFechaEnvioAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    }  
    public function getFechaRecepcionAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    }  
    public function getFechaEntregaAttribute($date){
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
    }  
    public function getFechaLiquidacionAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    } */                       
    public function presupuestooperatoriadetalle()
    {
    	return $this->belongsTo('App\Presupuestooperatoriadetalle');
    } 
    public function presupuestoortodonciadetalle()
    {
    	return $this->belongsTo('App\Presupuestoortodonciadetalle');
    }
    public function servicio()
    {
    	return $this->belongsTo('App\Servicio');
    } 
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }    
    public function sede()
    {
        return $this->belongsTo('App\Sede');
    }    
    public function laboratorioservicio()
    {
        return $this->belongsTo('App\Laboratorioservicio');
    }              
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
}
