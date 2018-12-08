<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    protected $table = "canjes";

    protected $fillable = ['id', 'motivo_canje','genera_canje_a','tipo_canje','numero_certificado','otorgar_a','user_id', 'estado','activo'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
}
