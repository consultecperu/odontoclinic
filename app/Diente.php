<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diente extends Model
{
    protected $table = "dientes";

    protected $fillable = ['id', 'codigo', 'nombre_diente','cuadrante','tipo','cara_1','cara_2','cara_3','cara_4','cara_5','sector'];

    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\Presupuestooperatoriadetalle');
    }
    public function presupuestosoperatorias()
    {
        return $this->belongsToMany('App\Presupuestooperatoria')->withTimestamps();
    }     

}
