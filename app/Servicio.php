<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = "servicios";

    protected $fillable = ['id', 'nombre_servicio', 'user_id', 'simbologia_id','tipo','parentid_ortodoncia','laboratorio','materiales','exodoncia','activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function simbologia()
    {
    	return $this->belongsTo('App\Simbologia');
    }     
    public function serviciodetalles()
    {
        return $this->hasMany('App\Serviciodetalle');
    }
    public function gruposervicios()
    {
        return $this->belongsToMany('App\Gruposervicio')->withTimestamps();
    }    
    public function laboratorios()
    {
        return $this->belongsToMany('App\Laboratorio')->withTimestamps();
    }   
    public function tarifarios()
    {
        return $this->hasMany('App\Tarifario');       
    }
    public function materialservicios()
    {
        return $this->hasMany('App\Materialservicio');
    }          
    
}
