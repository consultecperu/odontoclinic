<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependiente extends Model
{
    protected $table = "dependientes";

    protected $fillable = ['id', 'pacientetitular_id','pacientedependiente_id','parentesco_id','user_id','activo'];
    
    public function pacientetitular()
    {
        return $this->belongsTo('App\Paciente','id');
    }
    public function pacientedependiente()
    {
        return $this->belongsTo('App\Paciente','id');
    }  
    public function parentesco()
    {
        return $this->belongsTo('App\Parentesco');
    }      
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 

}
