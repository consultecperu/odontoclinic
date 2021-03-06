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
    protected $fillable = ['name', 'email', 'password' , 'perfil_id' , 'acceso', 'activo' , 'fecha_vencimiento','empleado_id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function perfile()
    {
        return $this->belongsTo('App\Perfile','perfil_id');
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
        return $this->hasMany('App\Sede');
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
    public function empresapacientes()
    {
        return $this->hasMany('App\Empresapaciente');
    } 
    public function polizas()
    {
        return $this->hasMany('App\Poliza');
    } 
    public function convenios()
    {
        return $this->hasMany('App\Convenio');
    }   
    public function campañas()
    {
        return $this->hasMany('App\Campaña');
    }  
    public function accesousers()
    {
        return $this->hasMany('App\AccesoUser');
    }   
    public function monedas()
    {
        return $this->hasMany('App\Moneda');        
    } 
    public function canjes()
    {
        return $this->hasMany('App\Canje');
    }  
    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }  
    public function laboratorioservicios()
    {
        return $this->hasMany('App\Laboratorioservicio');
    }   
    public function materialservicios()
    {
        return $this->hasMany('App\Materialservicio');
    } 
    public function __empleado()
    {
        return $this->belongsTo('App\Empleado','empleado_id');
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
    public function dependientes()
    {
        return $this->hasMany('App\Dependiente');
    }  
    public function pacienteplanes()
    {
        return $this->hasMany('App\Pacienteplan');
    } 
    public function derivaciones()
    {
        return $this->hasMany('App\Derivacion');
    }  
    public function tipocambios()
    {
        return $this->hasMany('App\TipoCambio');
    } 
    public function presupuestosoperatorias()
    {
        return $this->hasMany('App\Presupuestooperatoria');
    }       
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\Presupuestooperatoriadetalle');
    } 
    public function recordatencionoperatorias()
    {
        return $this->hasMany('App\Recordatencionoperatoria');
    } 
    public function recordatencionortodoncias()
    {
        return $this->hasMany('App\Recordatencionortodoncia');
    }        
    public function tipopagos()
    {
        return $this->hasMany('App\Tipopago');
    }  
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }  
    public function citas()
    {
        return $this->hasMany('App\Cita');
    } 
    public function seguimientocitas()
    {
        return $this->hasMany('App\Seguimientocita');
    }  
    public function laboratoriotrabajos()
    {
        return $this->hasMany('App\Laboratoriotrabajo')->orderBy('id');
    } 
    public function liquidacionlaboratorios()
    {
        return $this->hasMany('App\Liquidacionlaboratorio')->orderBy('id');
    }   
    public function liquidacionlaboratoriodetalles()
    {
        return $this->hasMany('App\Liquidacionlaboratoriodetalle');
    }
    public function conceptos()
    {
        return $this->hasMany('App\Concepto');
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
    public function seguimientoplanes()
    {
        return $this->hasMany('App\Seguimientoplane');
    }                                                                                                                               
}
