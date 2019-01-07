<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZonaPiezaDental extends Model
{
    protected $table = "zona_pieza_dental";

    protected $fillable = ['id', 'descripcion', 'orden', 'activo'];

}
