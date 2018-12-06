<?php

use Illuminate\Database\Seeder;
use App\Planpoliza;

class PlanpolizaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Planpoliza::create([
            'nombre_planpoliza' => 'TRAB. CONYUG. E HIJOS',
            'user_id'           => 2              
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'ACCIDENTES',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'CONVENIOS',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'ESTUDIANTES TITULARES',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'EX TRABAJADORES',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'MULTIDENT CARD',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'PADRES',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'PRACTICANTES',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'SCTR',
            'user_id'           => 2
        ]);
        Planpoliza::create([
            'nombre_planpoliza' => 'SOAT',
            'user_id'           => 2
        ]);                                                                        
    }
}
