<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionortodoncia extends Model
{
    protected $table = "liquidacionortodoncias";

    protected $fillable = ['id','empleado_id','sede_id','fecha_corte','monto_total_atenciones','monto_total_abonos','monto_total_descuentos','monto_total_liquidar','motivo_eliminacion','tipo','moneda_id','pagado','user_id','fecha_cancelacion','monto_liquidable','detraccion', 'activo'];
    
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
    	return $this->belongsTo('App\User');
    }        
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function transaccionesdoctor()
    {
        return $this->hasMany('App\Transacciondoctor');
    }
    public function liquidacionortodonciasdetalles()
    {
        return $this->hasMany('App\Liquidacionortodonciadetalle');
    }
    public function liquidacionortodonciastransacciones()
    {
        return $this->hasMany('App\Liquidacionortodonciatransaccione');
    }  
    public function liquidacionortodonciasfacturas()
    {
        return $this->hasMany('App\Liquidacionortodonciafactura');
    }              
}
