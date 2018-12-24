<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = "convenios";

    protected $fillable = ['id', 'empresapaciente_id', 'contacto','user_id','vigencia','fecha_inicio','fecha_finalizacion','email','telefono', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function empresapaciente()
    {
    	return $this->belongsTo('App\Empresapaciente');
    } 
    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }          
}
