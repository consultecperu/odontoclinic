<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = "laboratorios";

    protected $fillable = ['id', 'nombre_laboratorio', 'user_id', 'ruc','razon_social','activo'];
    
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
    public function recordatencionortodoncias()
    {
        return $this->hasMany('App\Recordatencionortodoncia');
    }  
    public function liquidacionlaboratorios()
    {
        return $this->hasMany('App\Liquidacionlaboratorio');
    }                             
}
