<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paciente extends Model
{
    protected $table = "pacientes";

    protected $fillable = ['id', 'tipodocumento_id','numero_documento','sede_id','nombres',
    'apellido_paterno','apellido_materno','fecha_nacimiento','sexo','ubigeo_id','direccion',
    'telefono','celular','email','estadocivil_id','motivocaptacion_id','telefono_mensajeria',
    'titular','mensajeria','foto','condicion_id','empleado_id','asignacion_id','fecha_ingreso',
    'nombre_completo','carnet','convenio_id','campania_id','historiaclinica','observacion',
    'apoderado','parentesco_apoderado_id','historial' ,'user_id', 'activo'];

    public function getFechaNacimientoAttribute($date){
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
    }
    public function getFechaIngresoAttribute($date){
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
    }    
    public function tipodocumento()
    {
    	return $this->belongsTo('App\Tipodocumento');
    }     
    public function sede()
    {
    	return $this->belongsTo('App\Sede');
    } 
    public function ubigeo()
    {
    	return $this->belongsTo('App\Ubigeo');
    }   
    public function estadocivil()
    {
    	return $this->belongsTo('App\EstadoCivile');
    }             
    public function motivocaptacion()
    {
    	return $this->belongsTo('App\Motivocaptacion');
    }    
    public function condicion()
    {
    	return $this->belongsTo('App\Condicion');
    }     
    public function empleado()
    {
    	return $this->belongsTo('App\Empleado');
    } 
    public function asignacion()
    {
    	return $this->belongsTo('App\Asignacion');
    }   
    public function convenio()
    {
    	return $this->belongsTo('App\Convenio');
    }  
    public function campania()
    {
    	return $this->belongsTo('App\Campania');
    }  
    public function historiaclinica()
    {
    	return $this->belongsTo('App\Historiaclinica');
    }  
    public function parentesco_apoderado()
    {
    	return $this->belongsTo('App\Parentesco','id');
    }  
    public function user()
    {
    	return $this->belongsTo('App\User');
    }   
    public function dependientes()
    {
        return $this->hasMany('App\Dependiente');
    } 
    public function pacienteplanes()
    {
        return $this->hasMany('App\Pacienteplan');
    }   
    public function pacientemultimedias()
    {
        return $this->hasMany('App\Pacientemultimedia');
    } 
    public function derivaciones()
    {
        return $this->hasMany('App\Derivacion');
    }                                                    
}
