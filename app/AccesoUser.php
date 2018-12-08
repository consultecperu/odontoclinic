<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccesoUser extends Model
{
    protected $table = "acceso_user";

    protected $fillable = ['id', 'acceso_id', 'user_id','crear','actualizar','eliminar','ver','autorizar','activo']; 
    
    public function acceso()
    {
    	return $this->belongsTo('App\Acceso');
    } 
    public function user()
    {
    	return $this->belongsTo('App\User');
    }   
}
