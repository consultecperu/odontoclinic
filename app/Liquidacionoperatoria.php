<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionoperatoria extends Model
{
    protected $table = "liquidacionoperatorias";

    protected $fillable = ['id','empleado_id','sede_id','fecha_corte','monto_total_atenciones','monto_total_abonos','monto_total_descuentos','monto_total_liquidar','motivo_eliminacion','tipo','moneda_id','pagado','user_id', 'activo'];
    
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
}
