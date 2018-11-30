<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = "ubigeos";

    protected $fillable = ['id', 'coddepa','codprov','coddist','descripcion','activo'];

    public function sedes()
    {
    	return $this->hasMany('App\Sede');
    } 
}
