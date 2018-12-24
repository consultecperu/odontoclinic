<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacientemultimedia extends Model
{
    protected $table = "paciente_multimedia";

    protected $fillable = ['id', 'paciente_id','nombre','archivo','tipo','user_id', 'activo'];
    
    public function paciente()
    {
    	return $this->belongsTo('App\Paciente');
    } 
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
 
}
