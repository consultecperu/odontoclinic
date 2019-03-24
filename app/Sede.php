<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = "sedes";

    protected $fillable = ['id', 'nombre_sede', 'ubigeo_id', 'direccion','telefono','celular','telef_adicional','correo','codigo','user_id', 'activo','plan_id'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function ubigeo()
    {
    	return $this->belongsTo('App\Ubigeo');
    } 
    public function plan()
    {
    	return $this->belongsTo('App\Plane');
    }          
    public function tarifarios()
    {
        return $this->hasMany('App\Tarifario');
    }
    public function empleados()
    {
        return $this->belongsToMany('App\Empleado')->withTimestamps();
    }  
    public function turnos()
    {
        return $this->hasMany('App\Turno');
    }    
    public function turnosespeciales()
    {
        return $this->hasMany('App\TurnoEspecial');
    } 
    public function permisos()
    {
        return $this->hasMany('App\Permiso');
    }
    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }  
    public function historiaclinicas()
    {
        return $this->hasMany('App\Historiaclinica');
    } 
    public function presupuestosoperatorias()
    {
        return $this->hasMany('App\Presupuestooperatoria');
    }  
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    } 
    public function citas()
    {
        return $this->hasMany('App\Cita');
    }
    public function laboratoriotrabajos()
    {
        return $this->hasMany('App\Laboratoriotrabajo')->orderBy('id');
    } 
    public function liquidacionlaboratorios()
    {
        return $this->hasMany('App\Liquidacionlaboratorio');
    } 
    public function liquidacionoperatorias()
    {
        return $this->hasMany('App\Liquidacionoperatoria');
    }   
    public function liquidacionortodoncias()
    {
        return $this->hasMany('App\Liquidacionortodoncia');
    }  
    public function transaccionesdoctor()
    {
        return $this->hasMany('App\Transacciondoctor');
    }                                                           
}
