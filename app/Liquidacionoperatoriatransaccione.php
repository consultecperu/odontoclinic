<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionoperatoriatransaccione extends Model
{
    protected $table = "liquidacionoperatoriastransacciones";

    protected $fillable = ['id','liquidacionoperatoria_id','transacciondoctor_id','activo'];
    
    public function liquidacionoperatoria()
    {
        return $this->belongsTo('App\Liquidacionoperatoria');
    }
    public function transacciondoctor()
    {
        return $this->belongsTo('App\Transacciondoctor');
    }    

}
