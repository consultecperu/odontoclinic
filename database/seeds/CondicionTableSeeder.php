<?php

use Illuminate\Database\Seeder;
use App\Condicion;

class CondicionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condicion::create([
            'nombre_parentesco'     => 'HIJO (A)',                 
        ]);
        Condicion::create([
            'nombre_parentesco'     => 'MADRE',                 
        ]);
        Condicion::create([
            'nombre_parentesco'     => 'PADRE',                 
        ]); 
        Condicion::create([
            'nombre_parentesco'     => 'ABUELO (A)',                 
        ]);
        Condicion::create([
            'nombre_parentesco'     => 'CONYUGE',                 
        ]);
        Condicion::create([
            'nombre_parentesco'     => 'HERMANO (A)',                 
        ]);   
        Condicion::create([
            'nombre_parentesco'     => 'TIO (A)',                 
        ]);
        Condicion::create([
            'nombre_parentesco'     => 'SOBRINO (A)',                 
        ]);
        Condicion::create([
            'nombre_parentesco'     => 'OTRO',                 
        ]);                                  
    }
}
