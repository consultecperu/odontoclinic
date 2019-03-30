<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionortodonciadetalle extends Model
{
    protected $table = "liquidacionortodonciasdetalle";

    protected $fillable = ['id','liquidacionortodoncia_id','presupuestoortodonciadetalle_id','comision','comision_tarjeta','tipo_pago','sunat','laboratorio','material_doctor','material_proveedor','neto','activo'];
    
    public function liquidacionortodoncia()
    {
        return $this->belongsTo('App\Liquidacionortodoncia');
    }
    public function presupuestoortodonciadetalle()
    {
        return $this->belongsTo('App\Presupuestoortodonciadetalle');
    }    
}
