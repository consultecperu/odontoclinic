<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    protected $table = "empleados";

    protected $fillable = ['id', 'tipodocumento_id', 'numero_documento','nombres','apellido_paterno','apellido_materno','fecha_nacimiento','sexo','direccion','telefono','celular','email','foto','ubigeo_id','COP','nconsultorio','tipocontrato_id','useracceso_id','estadocivil_id','tipopagodoctor_id','porcentaje_interno','porcentaje_aseguradora','fecha_ingreso','cargo_id','acceso_system','nombre_completo','tipo','user_id', 'activo'];

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
    public function ubigeo()
    {
    	return $this->belongsTo('App\Ubigeo');
    }  
    public function tipocontrato()
    {
    	return $this->belongsTo('App\Tipocontrato');
    } 
    public function useracceso()
    {
    	return $this->belongsTo('App\User');
    }    
    public function estadocivil()
    {
    	return $this->belongsTo('App\Estadocivile');
    }  
    public function tipopagodoctor()
    {
    	return $this->belongsTo('App\Tipopagodoctore');
    }   
    public function cargo()
    {
    	return $this->belongsTo('App\Cargo');
    }    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }    
    public function __user()
    {
        return $this->hasOne('App\User','empleado_id','id');
    }      
    public function sedes()
    {
        return $this->belongsToMany('App\Sede')->withTimestamps();
    } 
    public function turnos()
    {
        return $this->hasMany('App\Turno');
    }  
    public function turnosespeciales()
    {
        return $this->hasMany('App\TurnoEspecial');
    } 
    public function especialidades()
    {
        return $this->belongsToMany('App\Especialidade')->withTimestamps();
    } 
    public function permisos()
    {
        return $this->hasMany('App\Permiso');
    }   
    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }
    public function derivaciones()
    {
        return $this->hasMany('App\Derivacion');
    } 
    public function presupuestosoperatorias()
    {
        return $this->hasMany('App\PresupuestoOperatoria');
    }  
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\Presupuestooperatoriadetalle');
    }
    public function recordatencionoperatorias()
    {
        return $this->hasMany('App\Recordatencionoperatoria');
    }                                       
}
