<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuestooperatoria extends Model
{
    protected $table = "presupuestosoperatorias";

    protected $fillable = ['id', 'fecha_registro','paciente_id','empleado_id','moneda_id','numero_presupuesto','plan_id','poliza_id','tipo_presupuesto','estado_seguimiento','observaciones','estadopresupuesto_id','tipocambio_id','sede_id','pago_cliente','pago_aseguradora','pago_total','user_id','saldo','tipo_odontograma','saldo_tarjeta','tipopago_id','activo'];
    
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
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\Presupuestooperatoriadetalle')->orderBy('id');
    } 
    public function dientes()
    {
        return $this->belongsToMany('App\Diente')->withTimestamps();
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
