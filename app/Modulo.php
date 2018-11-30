<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = "modulos";

    protected $fillable = ['id', 'name', 'idparent', 'type', 'icono' ,'name_router','name_template','orden','active'];     
        
    public function perfiles()
    {
        return $this->belongsToMany('App\Perfile')->withTimestamps();
    }    
}
