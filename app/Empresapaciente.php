<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresapaciente extends Model
{
    protected $table = "empresapacientes";

    protected $fillable = ['id', 'ruc','razon_social','ubigeo_id', 'direccion','telefono','celular','codigo','email','user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function ubigeo()
    {
    	return $this->belongsTo('App\Ubigeo');
    } 
    public function empresapacienteplanes()
    {
        return $this->hasMany('App\EmpresapacientePlane');
    }      
    public function polizas()
    {
        return $this->hasMany('App\Poliza');
    }   
    public function convenios()
    {
        return $this->hasMany('App\Convenio');
    }  
    public function campañas()
    {
        return $this->hasMany('App\Campaña');
    } 
    public function pacienteplanes()
    {
        return $this->hasMany('App\Pacienteplan');
    }  
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }                          
    public function seguimientoplanes()
    {
        return $this->hasMany('App\Seguimientoplane');
    }         
}
