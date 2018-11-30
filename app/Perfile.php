<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfile extends Model
{
    protected $table = "perfiles";

    protected $fillable = ['id', 'nombre_perfil', 'descripcion', 'habilitado', 'activo'];     
    
    public function usuarios()
    {
        return $this->hasMany('App\User');
    }     

    public function modules()
    {
        return $this->belongsToMany('App\Modulo')->withTimestamps();
    }    

}
