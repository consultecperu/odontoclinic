<?php

use Illuminate\Database\Seeder;
use App\Estadopresupuesto;

class EstadoPresupuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estadopresupuesto::create([
            'nombre_estadopresupuesto'     => 'PENDIENTE'                 
        ]);
        Estadopresupuesto::create([
            'nombre_estadopresupuesto'     => 'PROCESO'                 
        ]);
        Estadopresupuesto::create([
            'nombre_estadopresupuesto'     => 'COMPLETADO'                 
        ]);
        Estadopresupuesto::create([
            'nombre_estadopresupuesto'     => 'CANCELADO'                 
        ]);                        
    }
}
