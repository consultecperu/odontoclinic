<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Liquidacionlaboratorio extends Model
{
    protected $table = "liquidacionlaboratorios";

    protected $fillable = ['id','fecha_liquidacion','codigo','tipodocumento_id','laboratorio_id','sede_id','serie','numero','monto','moneda_id','pagado','comentario','user_id','fecha_cancelacion','activo'];

    public function getFechaLiquidacionAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    }
    public function getFechaCancelacionAttribute($date){
        if(!is_null($date)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
        }
        return null;        
    }    
    public function tipodocumento()
    {
    	return $this->belongsTo('App\Tipodocumento');
    } 
    public function laboratorio()
    {
    	return $this->belongsTo('App\Laboratorio');
    }  
    public function sede()
    {
    	return $this->belongsTo('App\Sede');
    } 
    public function moneda()
    {
    	return $this->belongsTo('App\Moneda');
    }            
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function liquidacionlaboratoriodetalles()
    {
        return $this->hasMany('App\Liquidacionlaboratoriodetalle');
    }  
    public function liquidacionlaboratoriofacturas()
    {
        return $this->hasMany('App\Liquidacionlaboratoriofactura');
    }              
}
