<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacionortodonciatransaccione extends Model
{
    protected $table = "liquidacionortodonciastransacciones";

    protected $fillable = ['id','liquidacionortodoncia_id','transacciondoctor_id','activo'];
    
    public function liquidacionortodoncia()
    {
        return $this->belongsTo('App\Liquidacionortodoncia');
    }
    public function transacciondoctor()
    {
        return $this->belongsTo('App\Transacciondoctor');
    }  
}
