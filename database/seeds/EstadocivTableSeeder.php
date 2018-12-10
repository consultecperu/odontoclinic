<?php

use Illuminate\Database\Seeder;
use App\Estadocivile;

class EstadocivTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estadocivile::create([
            'nombre_estadocivil'        => 'CASADO(A)'          
        ]);
        Estadocivile::create([
            'nombre_estadocivil'        => 'SOLTERO(A)'        
        ]); 
        Estadocivile::create([
            'nombre_estadocivil'        => 'DIVORCIADO(A)'            
        ]);
        Estadocivile::create([
            'nombre_estadocivil'        => 'CONVIVIENTE'            
        ]);  
        Estadocivile::create([
            'nombre_estadocivil'        => 'VIUDO(A)'            
        ]);
    }
}
