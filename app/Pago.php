<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pago extends Model
{
    protected $table = "pagos";

    protected $fillable = ['id','sede_id','ptoventa','origen','presupuestooperatoria_id','presupuestoortodoncia_id','empleado_id','empresapaciente_id','tipodocumento_id','serie','numero','deducible','coaseguro','cliente','valor','igv','total','total_dolares','tipopago_id','user_id','fecha_pago','transferencia','ultimos_digitos','lote','monto_efectivo','monto_tarjeta','moneda_id','tipocambio_id','tipo','paciente_pago','disponible','vuelto','indicador','disponible_efectivo','disponible_tarjeta','contable', 'activo'];

    public function getFechaPagoAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');   //formateo de la fecha para verlo en el frontend
    }      
    public function sede()
    {
    	return $this->belongsTo('App\Sede');
    } 
    public function presupuestooperatoria()
    {
    	return $this->belongsTo('App\Presupuestooperatoria');
    }   
    public function presupuestoortodoncia()
    {
    	return $this->belongsTo('App\Presupuestoortodoncia');
    }          
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    } 
    public function empresapaciente()
    {
        return $this->belongsTo('App\Empresapaciente');
    }   
    public function tipodocumento()
    {
        return $this->belongsTo('App\Tipodocumento');
    }   
    public function tipopago()
    {
        return $this->belongsTo('App\Tipopago');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }  
    public function moneda()
    {
        return $this->belongsTo('App\Moneda');
    } 
    public function tipocambio()
    {
        return $this->belongsTo('App\TipoCambio');
    }                             
}
