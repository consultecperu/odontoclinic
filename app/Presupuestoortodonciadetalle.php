<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuestoortodonciadetalle extends Model
{
    protected $table = "presupuestosortodonciasdetalle";

    protected $fillable = ['id','presupuestoortodoncia_id','moneda_id','costo','costo_base','descuento','tipoplan','empleado_id','realizado','descargado','pagado','tipo_pagado','adicional','laboratorio_id','monto_lab','material_id','monto_mat','user_id','activo','numero_cuota','tarifario_id','descripcion'];
    
    public function presupuestoortodoncia()
    {
    	return $this->belongsTo('App\Presupuestoortodoncia');
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

}
