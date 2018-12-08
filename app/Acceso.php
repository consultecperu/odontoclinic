<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table = "accesos";

    protected $fillable = ['id', 'nombre', 'key', 'activo'];

    public function accesousers()
    {
        return $this->hasMany('App\AccesoUser');
    }               
    
}
