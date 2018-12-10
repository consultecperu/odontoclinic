<?php

use Illuminate\Database\Seeder;
use App\Especialidade;

class EspecialidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Especialidade::create([
            'nombre_especialidad'       => 'ODONTOLOGIA INTEGRAL',
            'peso'                      => 1.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'REHABILITACION ORAL',
            'peso'                      => 1.50          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'ESTETICA DENTAL',
            'peso'                      => 1.50          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'ENDODONCIA',
            'peso'                      => 1.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'ODONTOPEDIATRIA',
            'peso'                      => 1.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'ORTODONCIA',
            'peso'                      => 2.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'PERIODONCIA-CIRUGIA-IMPLANTES',
            'peso'                      => 2.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'CIRUGIA-IMPLANTES',
            'peso'                      => 2.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'PERIODONCIA-IMPLANTES',
            'peso'                      => 2.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'COSMETICA DENTAL',
            'peso'                      => 1.50          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'RADIOLOGIA',
            'peso'                      => 1.00          
        ]);
        Especialidade::create([
            'nombre_especialidad'       => 'CIRUGIA MAXILOFACIAL',
            'peso'                      => 2.00          
        ]);                                                                                                       
    }
}
