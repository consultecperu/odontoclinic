<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaña extends Model
{
    protected $table = "campanias";

    protected $fillable = ['id', 'empresapaciente_id','nombre_campania','lugar','fecha_realizacion','fecha_vencimiento','contacto','vigencia','telefono', 'user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function empresapaciente()
    {
    	return $this->belongsTo('App\Empresapaciente');
    }        
}
