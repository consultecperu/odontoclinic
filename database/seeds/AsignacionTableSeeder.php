<?php

use Illuminate\Database\Seeder;
use App\Asignacion;

class AsignacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asignacion::create([
            'nombre_asignacion'     => 'DIRECTO'                 
        ]);
        Asignacion::create([
            'nombre_asignacion'     => 'ESPECIALIDAD '                  
        ]);
        Asignacion::create([
            'nombre_asignacion'     => 'DERIVACION',
            'activo'                => false                
        ]);
        Asignacion::create([
            'nombre_asignacion'     => 'DISPONIBILIDAD'                  
        ]);
    }
}
