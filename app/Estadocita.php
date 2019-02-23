<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadocita extends Model
{
    protected $table = "estadocitas";

    protected $fillable = ['id', 'nombre_estadocita','orden','color','color_disabled','color_font','color_border','activo'];

    public function seguimientocitas()
    {
        return $this->hasMany('App\Seguimientocita');
    }      
}
