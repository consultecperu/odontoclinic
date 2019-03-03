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
    public function serviciodetalle()
    {
        return $this->hasOne('App\Serviciodetalle');
    }
    public function gruposervicios()
    {
        return $this->belongsToMany('App\Gruposervicio')->withTimestamps();
    }    
    public function laboratorioservicios()
    {
        return $this->belongsToMany('App\Laboratorioservicio')->withTimestamps();
    }   
    public function tarifarios()
    {
        return $this->hasMany('App\Tarifario');       
    }
    public function materialservicios()
    {
        return $this->hasMany('App\Materialservicio');
    }
    public function derivaciones()
    {
        return $this->hasMany('App\Derivacion');
    }  
    public function laboratoriotrabajos()
    {
        return $this->hasMany('App\Laboratoriotrabajo')->orderBy('id');
    }                       
    
}
