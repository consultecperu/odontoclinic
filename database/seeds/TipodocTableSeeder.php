<?php

use Illuminate\Database\Seeder;
use App\Tipodocumento;

class TipodocTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'DNI',
            'abreviatura'               => 'DNI',
            'tipo'                      => 1            
        ]);
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'CARNET DE EXTRANJERIA',
            'abreviatura'               => 'C.E',
            'tipo'                      => 1            
        ]); 
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'PASAPORTE',
            'abreviatura'               => 'P.A',
            'tipo'                      => 1            
        ]);
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'SIN DOCUMENTO',
            'abreviatura'               => 'S.D',
            'tipo'                      => 1            
        ]);  
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'BOLETA',
            'abreviatura'               => 'BO',
            'tipo'                      => 2            
        ]);
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'FACTURA',
            'abreviatura'               => 'FA',
            'tipo'                      => 2            
        ]); 
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'RECIBO',
            'abreviatura'               => 'RE',
            'tipo'                      => 2            
        ]);
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'TRANSFERENCIA',
            'abreviatura'               => 'TR',
            'tipo'                      => 2            
        ]);
        Tipodocumento::create([
            'nombre_tipodocumento'      => 'REGULARIZACION SISTEMA ANTERIOR',
            'abreviatura'               => 'RSA',
            'tipo'                      => 2           
        ]);                                
    }
}
