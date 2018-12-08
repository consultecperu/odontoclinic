<?php

use Illuminate\Database\Seeder;
use App\Acceso;

class AccesosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acceso::create([
            'nombre'    => 'Canjes',
            'key'       => 'keycan'              
        ]);
    }
}
