<?php

use Illuminate\Database\Seeder;
use App\Tipopagodoctore;

class TipopagdocTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipopagodoctore::create([
            'nombre_tipopagodoctor'      => 'POR TRABAJO ACABADO'       
        ]);
        Tipopagodoctore::create([
            'nombre_tipopagodoctor'      => 'POR AVANCES'            
        ]); 
    }
}
