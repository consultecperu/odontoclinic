<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Recordatencionortodoncia extends Model
{
    protected $table = "recordatencionortodoncias";

    protected $fillable = ['id', 'presupuestoortodonciadetalle_id', 'fase_id','descripcion','realizado','comentario','empleado_id','fecha_realizacion','user_id','laboratorio_id','material_id','activo'];

    public function getFechaRealizacionAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    }    
    public function presupuestoortodonciadetalle()
    {
    	return $this->belongsTo('App\Presupuestoortodonciadetalle');
    }
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function laboratorio()
    {
    	return $this->belongsTo('App\Laboratorio');
    } 
    public function material()
    {
    	return $this->belongsTo('App\Materiale');
    }         

}
