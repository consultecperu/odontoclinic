<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiale extends Model
{
    protected $table = "materiales";

    protected $fillable = ['id', 'nombre_material', 'devolucion','moneda_id','user_id', 'activo','costo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function moneda()
    {
    	return $this->belongsTo('App\Moneda');
    }   
    public function materialservicios()
    {
        return $this->hasMany('App\Materialservicio');
    } 
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\PresupuestoOperatoriaDetalle');
    }             
}
