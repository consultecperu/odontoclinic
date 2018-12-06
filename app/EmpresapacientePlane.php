<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresapacientePlane extends Model
{
    protected $table = "empresapaciente_plane";

    protected $fillable = ['id', 'empresapaciente_id', 'plane_id','activo']; 
    
    public function empresapaciente()
    {
    	return $this->belongsTo('App\Empresapaciente');
    } 
    public function plane()
    {
    	return $this->belongsTo('App\Plane');
    }          
}
