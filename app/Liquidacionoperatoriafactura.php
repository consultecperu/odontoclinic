<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionoperatoriafactura extends Model
{
    protected $table = "liquidacionoperatoriasfacturas";

    protected $fillable = ['id','liquidacionoperatoria_id','tipodocumento_id','serie','numero','monto','activo'];
    
    public function liquidacionoperatoria()
    {
        return $this->belongsTo('App\Liquidacionoperatoria');
    }
    public function tipodocumento()
    {
        return $this->belongsTo('App\Tipodocumento');
    }    
}
