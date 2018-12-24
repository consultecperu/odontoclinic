<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historiaclinica extends Model
{
    protected $table = "historiaclinicas";

    protected $fillable = ['id', 'sede_id','correlativo_sede','correlativo_general'];

    public function sede()
    {
    	return $this->belongsTo('App\Sede');
    }  
    public function paciente()
    {
        return $this->hasOne('App\Paciente');
    }         
}
