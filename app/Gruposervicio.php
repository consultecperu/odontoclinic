<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gruposervicio extends Model
{
    protected $table = "gruposervicios";

    protected $fillable = ['id', 'nombre_gruposervicio', 'tipo', 'user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function servicios()
    {
        return $this->belongsToMany('App\Servicio')->withTimestamps();
    }      
}
