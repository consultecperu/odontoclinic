<?php

use Illuminate\Database\Seeder;
use App\Parentesco;

class ParentescoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parentesco::create([
            'nombre_parentesco'     => 'HIJO (A)',                 
        ]);
        Parentesco::create([
            'nombre_parentesco'     => 'MADRE',                 
        ]);
        Parentesco::create([
            'nombre_parentesco'     => 'PADRE',                 
        ]); 
        Parentesco::create([
            'nombre_parentesco'     => 'ABUELO (A)',                 
        ]);
        Parentesco::create([
            'nombre_parentesco'     => 'CONYUGE',                 
        ]);
        Parentesco::create([
            'nombre_parentesco'     => 'HERMANO (A)',                 
        ]);   
        Parentesco::create([
            'nombre_parentesco'     => 'TIO (A)',                 
        ]);
        Parentesco::create([
            'nombre_parentesco'     => 'SOBRINO (A)',                 
        ]);
        Parentesco::create([
            'nombre_parentesco'     => 'OTRO',                 
        ]); 
    }
}
