<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = "monedas";

    protected $fillable = ['id', 'nombre_moneda', 'user_id', 'activo','abreviatura'];

    public function materiales()
    {
    	return $this->hasMany('App\Materiale');
    } 
}
