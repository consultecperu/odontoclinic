<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = "monedas";

    protected $fillable = ['id', 'nombre_moneda', 'user_id', 'activo','abreviatura'];

    public function materiales()
    {
    	return $this->hasMany('App\Materiale');
    } 
    public function tarifarios()
    {
        return $this->hasMany('App\Tarifario');
    }  
    public function polizas()
    {
        return $this->hasMany('App\Poliza');
    }  
    public function laboratorioservicios()
    {
        return $this->hasMany('App\Laboratorioservicio');
    }     
    public function tipocambios()
    {
        return $this->hasMany('App\TipoCambio');
    }
    public function presupuestosoperatorias()
    {
        return $this->hasMany('App\TipoCambio');
    }   
    public function presupuestosoperatoriasdetalles()
    {
        return $this->hasMany('App\Presupuestooperatoriadetalle');
    }             
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function pagos()
    {
        return $this->hasMany('App\Pago');
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
