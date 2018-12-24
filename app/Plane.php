<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $table = "planes";

    protected $fillable = ['id', 'descripcion', 'abreviatura','ruc','direccion','telefono','facturar_a','comentario','principal','tipo','facturacion_mltd','descuento', 'user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function tarifarios()
    {
        return $this->hasMany('App\Tarifario');       
    }  
    public function empresapacienteplanes()
    {
        return $this->hasMany('App\EmpresapacientePlane');
    }                
    public function polizas()
    {
        return $this->hasMany('App\Poliza');
    }   
    public function pacienteplanes()
    {
        return $this->hasMany('App\Pacienteplane');
    }       
}
