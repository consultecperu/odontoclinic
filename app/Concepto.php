<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $table = "conceptos";

    protected $fillable = ['id', 'nombre_concepto','type','user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function transaccionesdoctor()
    {
        return $this->hasMany('App\Transacciondoctor');
    }      

}
