<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    protected $table = "parentescos";

    protected $fillable = ['id', 'nombre_parentesco', 'activo'];

    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }  
    public function dependientes()
    {
        return $this->hasMany('App\Dependiente');
    }             
    
}
