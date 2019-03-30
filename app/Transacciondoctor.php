<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Transacciondoctor extends Model
{
    protected $table = "transaccionesdoctor";

    protected $fillable = ['id','empleado_id','sede_id','moneda_id','concepto_id','fecha','descripcion','total','ind_liquidacion','liquidacionoperatoria_id','liquidacionortodoncia_id','liquidado','origen','user_id', 'activo'];

    public function getFechaAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    }    
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    } 
    public function sede()
    {
        return $this->belongsTo('App\Sede');
    }   
    public function moneda()
    {
        return $this->belongsTo('App\Moneda');
    } 
    public function concepto()
    {
        return $this->belongsTo('App\Concepto');
    }  
    public function liquidacionoperatoria()
    {
        return $this->belongsTo('App\Liquidacionoperatoria');
    }      
    public function liquidacionortodoncia()
    {
        return $this->belongsTo('App\Liquidacionortodoncia');
    }              
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function liquidacionoperatoriastransacciones()
    {
        return $this->hasMany('App\Liquidacionoperatoriatransaccione');
    }        
}
