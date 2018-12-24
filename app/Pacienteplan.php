<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacienteplan extends Model
{
    protected $table = "paciente_plan";

    protected $fillable = ['id', 'paciente_id', 'tipo','plan_id','descripcion','empresapaciente_id','poliza_id','user_id','activo'];
    
    public function paciente()
    {
    	return $this->belongsTo('App\Paciente');
    } 
    public function plan()
    {
        return $this->belongsTo('App\Plane');
    }  
    public function empresapaciente()
    {
        return $this->belongsTo('App\Empresapaciente');
    }     
    public function poliza()
    {
        return $this->belongsTo('App\Poliza');
    }    
    public function user()
    {
        return $this->belongsTo('App\User');
    }                  
}
