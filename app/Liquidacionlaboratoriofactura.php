<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionlaboratoriofactura extends Model
{
    protected $table = "liquidacionlaboratoriosfacturas";

    protected $fillable = ['id','liquidacionlaboratorio_id','tipodocumento_id','serie','numero','monto','activo'];
    
    public function liquidacionlaboratorio()
    {
    	return $this->belongsTo('App\Liquidacionlaboratorio');
    } 
    public function tipodocumento()
    {
    	return $this->belongsTo('App\Tipodocumento');
    }   
}
