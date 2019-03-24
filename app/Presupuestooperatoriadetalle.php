<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuestooperatoriadetalle extends Model
{
    protected $table = "presupuestosoperatoriasdetalle";

    protected $fillable = ['id','presupuestooperaroria_id','tarifario_id','tarifa','moneda_id','deducible','solocoaseguro','pago_cliente','pago_aseguradora','costo','costo_base','descuento','tipo_odontograma','empleado_id','realizado','descargado','pagado','tipo_pagado','laboratorio_id','monto_lab','material_id','monto_mat','solicitud','user_id','diente_id','caras','letras','simbologia_id','texto_diente','pago_id','liquidado','fecha_descarga','monto_efectivo','monto_tarjeta','tipopago_id','activo'];
    
    public function presupuestooperatoria()
    {
    	return $this->belongsTo('App\Presupuestooperatoria');
    }
    public function tarifario()
    {
    	return $this->belongsTo('App\Tarifario');
    }    
    public function moneda()
    {
    	return $this->belongsTo('App\Moneda');
    }  
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }  
    public function laboratorio()
    {
        return $this->belongsTo('App\Laboratorio');
    }  
    public function material()
    {
        return $this->belongsTo('App\Materiale');
    }                
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function diente()
    {
        return $this->belongsTo('App\Diente');
    } 
    public function simbologia()
    {
        return $this->belongsTo('App\Simbologia');
    }
    public function pago()
    {
        return $this->belongsTo('App\Pago');
    }    
    public function tipopago()
    {
        return $this->belongsTo('App\Tipopago');
    }        
    public function recordatencionoperatorias()
    {
        return $this->hasMany('App\Recordatencionoperatoria')->orderBy('id');
    }     
    public function laboratoriotrabajos()
    {
        return $this->hasMany('App\Laboratoriotrabajo')->orderBy('id');
    }       
}
