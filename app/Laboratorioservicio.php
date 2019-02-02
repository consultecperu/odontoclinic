<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorioservicio extends Model
{
    protected $table = "laboratorioservicios";

    protected $fillable = ['id', 'laboratorio_id', 'fase_id', 'costo_lab','costo_doctor','nombre_servicio','moneda_id','user_id','activo'];
    
    public function laboratorio()
    {
    	return $this->belongsTo('App\Laboratorio');
    } 
    public function moneda()
    {
        return $this->belongsTo('App\Moneda');
    } 
    public function servicios()
    {
        return $this->belongsToMany('App\Servicio')->withTimestamps();
    }      
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 

}
