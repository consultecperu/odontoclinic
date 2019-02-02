<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simbologia extends Model
{
    protected $table = "simbologias";

    protected $fillable = ['id', 'nombre_simbologia', 'imagen_rojo','tipo','imagen','imagen_azul', 'activo'];
    
    public function servicios()
    {
        return $this->hasMany('App\Servicio');
    } 
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\PresupuestoOperatoriaDetalle');
    }    
}
