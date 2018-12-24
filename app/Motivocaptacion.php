<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motivocaptacion extends Model
{
    protected $table = "motivocaptaciones";

    protected $fillable = ['id', 'nombre_motivocaptacion', 'activo'];

    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }     
    
}
