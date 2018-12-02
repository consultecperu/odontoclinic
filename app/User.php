<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password' , 'perfil_id' , 'acceso', 'activo' , 'fecha_vencimiento'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function perfile()
    {
        return $this->belongsTo('App\Perfile');
    }        
    public function cargos()
    {
        return $this->hasMany('App\Cargo');
    }       
    public function gruposervicios()
    {
        return $this->hasMany('App\Gruposervicio');
    }      
    public function laboratorios()
    {
        return $this->hasMany('App\Laboratorio');
    }
    public function sedes()
    {
        return $this->hasMany('App\Laboratorio');
    }      
    public function empresaadministradoras()
    {
        return $this->hasMany('App\Empresaadministradora');
    }     
    public function servicios()
    {
        return $this->hasMany('App\Servicio');
    }        
    public function planes()
    {
        return $this->hasMany('App\Plane');
    }
    public function tarifarios()
    {
        return $this->hasMany('App\Tarifario');
    }             
}
