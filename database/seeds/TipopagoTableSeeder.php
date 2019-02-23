<?php

use Illuminate\Database\Seeder;
use App\Tipopago;

class TipopagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipopago::create([
            'descripcion'               => 'EFECTIVO',
            'comision'                  => 0,
            'comision_liquidacion'      => 0,
            'tipo'                      => 1,
            'comision_emisor'           => NULL,
            'user_id'                   => 2
        ]);
        Tipopago::create([
            'descripcion'               => 'MASTERCARD',
            'comision'                  => 5.00,
            'comision_liquidacion'      => 10,
            'tipo'                      => 2,
            'comision_emisor'           => 20.00,
            'user_id'                   => 2
        ]);  
        Tipopago::create([
            'descripcion'               => 'VISA',
            'comision'                  => 4.50,
            'comision_liquidacion'      => 7,
            'tipo'                      => 2,
            'comision_emisor'           => 20.00,
            'user_id'                   => 2
        ]); 
        Tipopago::create([
            'descripcion'               => 'PUNTOS VIDA BBVA',
            'comision'                  => 0,
            'comision_liquidacion'      => 0,
            'tipo'                      => 2,
            'comision_emisor'           => 0,
            'user_id'                   => 2
        ]);  
        Tipopago::create([
            'descripcion'               => 'AB.BANCO',
            'comision'                  => 0,
            'comision_liquidacion'      => 0,
            'tipo'                      => 2,
            'comision_emisor'           => 0,
            'user_id'                   => 2
        ]); 
        Tipopago::create([
            'descripcion'               => 'AMEX',
            'comision'                  => 10.00,
            'comision_liquidacion'      => 10,
            'tipo'                      => 2,
            'comision_emisor'           => 0,
            'user_id'                   => 2
        ]);
        Tipopago::create([
            'descripcion'               => 'DINERS CLUB',
            'comision'                  => 4.50,
            'comision_liquidacion'      => 12,
            'tipo'                      => 2,
            'comision_emisor'           => 0,
            'user_id'                   => 2
        ]);                                          
    }
}
