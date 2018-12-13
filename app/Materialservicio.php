<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materialservicio extends Model
{
    protected $table = "materialservicios";

    protected $fillable = ['id', 'material_id', 'servicio_id','user_id', 'activo'];
    
    public function material()
    {
    	return $this->belongsTo('App\Materiale');
    }     
    public function servicio()
    {
    	return $this->belongsTo('App\Servicio');
    }     
    public function user()
    {
    	return $this->belongsTo('App\User');
    }             
}
