<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionoperatoriadetalle extends Model
{
    protected $table = "liquidacionoperatoriasdetalle";

    protected $fillable = ['id','liquidacionoperatoria_id','presupuestooperatoriadetalle_id','comision','comision_tarjeta','tipo_pago','sunat','laboratorio','material_doctor','material_proveedor','neto','activo'];
    
    public function liquidacionoperatoria()
    {
        return $this->belongsTo('App\Liquidacionoperatoria');
    }
    public function presupuestooperatoriadetalle()
    {
        return $this->belongsTo('App\Presupuestooperatoriadetalle');
    }    
 
}
