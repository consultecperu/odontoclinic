<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diente extends Model
{
    protected $table = "dientes";

    protected $fillable = ['id', 'codigo', 'nombre_diente','cuadrante','tipo'];

}
