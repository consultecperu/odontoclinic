<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresaadministradora extends Model
{
    protected $table = "empresaadministradoras";

    protected $fillable = ['id', 'nombre_empresa', 'ruc','ubigeo_id', 'direccion','telefono','celular','telef_adicional','email','logo','representante_legal','user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 

    public function ubigeo()
    {
    	return $this->belongsTo('App\Ubigeo');
    }     
}
