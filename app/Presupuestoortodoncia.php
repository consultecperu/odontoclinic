<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuestoortodoncia extends Model
{
    protected $table = "presupuestosortodoncias";

    protected $fillable = ['id', 'fecha_registro','paciente_id','empleado_id','codigo','cuotas','cuota_inicial','descuento','control_mensual','observaciones','tipocambio_id','estadopresupuesto_id','moneda_id','total_dolares','total_soles','total','sede_id','estado_seguimiento','cuota_inicial_base','control_mensual_base','user_id','saldo','activo','tarifario_id','cuota_inicial_dolares','control_mensual_dolares','cuota_inicial_base_dolares','control_mensual_base_dolares','saldo_tarjeta','tipopago_id','plan_id'];
    
    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    } 
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }    
    public function moneda()
    {
        return $this->belongsTo('App\Moneda');
    } 
    public function plan()
    {
        return $this->belongsTo('App\Plane');
    }    
    public function poliza()
    {
        return $this->belongsTo('App\Poliza');
    }      
    public function estadopresupuesto()
    {
        return $this->belongsTo('App\Estadopresupuesto');
    }  
    public function tarifario()
    {
        return $this->belongsTo('App\Tarifario');
    }   
    public function tipocambio()
    {
        return $this->belongsTo('App\TipoCambio');
    }      
    public function sede()
    {
        return $this->belongsTo('App\Sede');
    }
    public function tipopago()
    {
        return $this->belongsTo('App\Tipopago');
    }      
    public function presupuestosortodonciasdetalles()
    {
        return $this->hasMany('App\Presupuestoortodonciadetalle')->orderBy('id');;
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
