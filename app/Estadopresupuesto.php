<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadopresupuesto extends Model
{
    protected $table = "estadopresupuestos";

    protected $fillable = ['id', 'nombre_estadopresupuesto', 'activo'];

    public function presupuestosoperatorias()
    {
        return $this->hasMany('App\Presupuestooperatoria');
    }      
     
}
