<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = "laboratorios";

    protected $fillable = ['id', 'nombre_laboratorio', 'user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function servicios()
    {
        return $this->belongsToMany('App\Servicio')->withTimestamps();
    } 
    public function laboratorioservicios()
    {
        return $this->hasMany('App\Laboratorioservicio');
    }  
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\PresupuestoOperatoriaDetalle');
    } 
    public function recordatencionoperatorias()
    {
        return $this->hasMany('App\Recordatencionoperatoria');
    }                    
}
