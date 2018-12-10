<?php

use Illuminate\Database\Seeder;
use App\Tipocontrato;

class TipocontTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipocontrato::create([
            'nombre_tipocontrato'      => 'FACTURA'       
        ]);
        Tipocontrato::create([
            'nombre_tipocontrato'      => 'RECIBO POR HONORARIOS'         
        ]); 
        Tipocontrato::create([
            'nombre_tipocontrato'      => 'PLANILLA'         
        ]);
    }
}
