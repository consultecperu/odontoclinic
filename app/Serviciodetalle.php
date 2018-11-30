<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serviciodetalle extends Model
{
    protected $table = "serviciodetalles";

    protected $fillable = ['id', 'servicio_id','control_ortodoncia','cuota_inicial','ortofacil', 'activo'];
    
    public function servicio()
    {
    	return $this->belongsTo('App\Servicio');
    } 
}
