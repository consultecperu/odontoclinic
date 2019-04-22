<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguimientoplane extends Model
{
    protected $table = "seguimientoplanes";

    protected $fillable = ['id', 'fecha','paciente_id','tipo','plan_id','empresapaciente_id','poliza_id','user_id', 'activo'];
    
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
