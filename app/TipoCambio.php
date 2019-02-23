<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TipoCambio extends Model
{
    protected $table = "tipocambios";

    protected $fillable = ['id', 'fecha_registro','valor_compra','valor_venta','tipo_cambio','monedade_id','monedaa_id','user_id', 'activo'];

    public function getFechaRegistroAttribute($date){
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
    }    
    public function monedade()
    {
        return $this->belongsTo('App\Moneda');
    } 
    public function monedaa()
    {
        return $this->belongsTo('App\Moneda');
    } 
    public function presupuestosoperatorias()
    {
        return $this->hasMany('App\Presupuestooperatoria');
    }        
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }          
}
