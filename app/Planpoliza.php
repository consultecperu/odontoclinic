<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planpoliza extends Model
{
    protected $table = "planpolizas";

    protected $fillable = ['id', 'nombre_planpoliza', 'user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function polizas()
    {
        return $this->hasMany('App\Poliza');
    }         
}
