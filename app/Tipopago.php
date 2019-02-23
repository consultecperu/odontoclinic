<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipopago extends Model
{
    protected $table = "tipopagos";

    protected $fillable = ['id', 'descripcion', 'comision','comision_liquidacion','tipo','comision_emisor','user_id', 'activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }         
}
