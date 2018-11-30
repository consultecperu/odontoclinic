<?php

use Illuminate\Database\Seeder;
use App\Simbologia;

class SimbologiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Simbologia::create([
            'nombre_simbologia' => 'NORMAL - SUPERFICIE',
            'imagen_rojo'       => '',
            'tipo'              => 'NO',
            'imagen'            => 'normail.png', 
            'imagen_azul'       => ''                
        ]);
        Simbologia::create([
            'nombre_simbologia' => 'ENDODONCIA',
            'imagen_rojo'       => 'endodoncia_rojo.png',
            'tipo'              => 'EN',
            'imagen'            => 'endodoncia.png', 
            'imagen_azul'       => 'endodoncia_azul.png'                
        ]); 
        Simbologia::create([
            'nombre_simbologia' => 'CORONA',
            'imagen_rojo'       => 'corona_rojo.png',
            'tipo'              => 'CO',
            'imagen'            => 'corona.png', 
            'imagen_azul'       => 'corona_azul.png'                
        ]);   
        Simbologia::create([
            'nombre_simbologia' => 'EXODONCIA',
            'imagen_rojo'       => 'exodoncia_rojo.png',
            'tipo'              => 'EX',
            'imagen'            => 'exodoncia.png', 
            'imagen_azul'       => 'exodoncia_azul.png'                
        ]);   
        Simbologia::create([
            'nombre_simbologia' => 'PERNO',
            'imagen_rojo'       => 'perno_rojo.png',
            'tipo'              => 'PE',
            'imagen'            => 'perno.png', 
            'imagen_azul'       => 'perno_azul.png'                
        ]);     
        Simbologia::create([
            'nombre_simbologia' => 'IONOMERO',
            'imagen_rojo'       => 'ionomero_rojo.png',
            'tipo'              => 'LO',
            'imagen'            => 'ionomero.png', 
            'imagen_azul'       => 'ionomero_azul.png'                
        ]);     
        Simbologia::create([
            'nombre_simbologia' => 'SELLANTE',
            'imagen_rojo'       => 'sellante_rojo.png',
            'tipo'              => 'SE',
            'imagen'            => 'sellante.png', 
            'imagen_azul'       => 'sellante_azul.png'                
        ]); 
        Simbologia::create([
            'nombre_simbologia' => 'GENERAL',
            'imagen_rojo'       => 'general_rojo.png',
            'tipo'              => 'GE',
            'imagen'            => 'general.png', 
            'imagen_azul'       => 'general_azul.png'                
        ]);                                      
    }
}
