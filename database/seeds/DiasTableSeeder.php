<?php

use Illuminate\Database\Seeder;
use App\Dia;

class DiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dia::create([
            'nombre_dia'            => 'LUNES',
            'valor'                 => '1',       
        ]);
        Dia::create([
            'nombre_dia'            => 'MARTES',
            'valor'                 => '2',       
        ]);   
        Dia::create([
            'nombre_dia'            => 'MIERCOLES',
            'valor'                 => '3',       
        ]);   
        Dia::create([
            'nombre_dia'            => 'JUEVES',
            'valor'                 => '4',       
        ]);   
        Dia::create([
            'nombre_dia'            => 'VIERNES',
            'valor'                 => '5',       
        ]);   
        Dia::create([
            'nombre_dia'            => 'SABADO',
            'valor'                 => '6',       
        ]);   
        Dia::create([
            'nombre_dia'            => 'DOMINGO',
            'valor'                 => '0',       
        ]);                                                      
    }
}
