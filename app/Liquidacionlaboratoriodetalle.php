<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionlaboratoriodetalle extends Model
{
    protected $table = "liquidacionlaboratoriosdetalle";

    protected $fillable = ['id', 'liquidacionlaboratorio_id','laboratoriotrabajo_id','user_id', 'activo'];
    
    public function liquidacionlaboratorio()
    {
    	return $this->belongsTo('App\Liquidacionlaboratorio');
    } 
    public function laboratoriotrabajo()
    {
    	return $this->belongsTo('App\Laboratoriotrabajo');
    } 
    public function user()
    {
    	return $this->belongsTo('App\User');
    }         
}
