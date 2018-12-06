<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poliza extends Model
{
    protected $table = "polizas";

    protected $fillable = ['id', 'codigo', 'vigencia_del','vigencia_al','moneda_id','deducible','coaseguro','comentario','user_id','planpoliza_id','empresapaciente_id','plane_id','activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function moneda()
    {
    	return $this->belongsTo('App\Moneda');
    }     
    public function planpoliza()
    {
    	return $this->belongsTo('App\Planpoliza');
    }   
    public function empresapaciente()
    {
    	return $this->belongsTo('App\Empresapaciente');
    }      
    public function plane()
    {
    	return $this->belongsTo('App\Plane');
    }      
}
