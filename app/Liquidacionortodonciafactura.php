<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionortodonciafactura extends Model
{
    protected $table = "liquidacionortodonciasfacturas";

    protected $fillable = ['id','liquidacionortodoncia_id','tipodocumento_id','serie','numero','monto','activo'];
    
    public function liquidacionortodoncia()
    {
        return $this->belongsTo('App\Liquidacionortodoncia');
    }
    public function tipodocumento()
    {
        return $this->belongsTo('App\Tipodocumento');
    }    
}
