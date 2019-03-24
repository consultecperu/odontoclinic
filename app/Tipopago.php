<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipopago extends Model
{
    protected $table = "tipopagos";

    protected $fillable = ['id', 'descripcion', 'comision','comision_liquidacion','tipo','comision_emisor','user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }  
    public function presupuestosoperatorias()
    {
        return $this->hasMany('App\Presupuestooperatoria');
    }   
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\Presupuestooperatoriadetalle');
    }
    public function presupuestosortodoncias()
    {
        return $this->hasMany('App\Presupuestoortodoncia');
    }   
    public function presupuestosortodonciasdetalles()
    {
        return $this->hasMany('App\Presupuestoortodonciadetalle');
    }                 
}
