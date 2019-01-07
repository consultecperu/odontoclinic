<?php

use Illuminate\Database\Seeder;
use App\ZonaPiezaDental;

class ZonaPiezaDentalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ZonaPiezaDental::create([
            'descripcion'               => 'INCISAL',
            'orden'                     => '1',       
        ]);
        ZonaPiezaDental::create([
            'descripcion'               => 'VESTIBULAR',
            'orden'                     => '2',       
        ]);
        ZonaPiezaDental::create([
            'descripcion'               => 'PALATINO',
            'orden'                     => '3',       
        ]);
        ZonaPiezaDental::create([
            'descripcion'               => 'MESIAL',
            'orden'                     => '4',       
        ]);
        ZonaPiezaDental::create([
            'descripcion'               => 'DISTAL',
            'orden'                     => '5',       
        ]);
        ZonaPiezaDental::create([
            'descripcion'               => 'OCLUSAL',
            'orden'                     => '1',       
        ]);
        ZonaPiezaDental::create([
            'descripcion'               => 'LINGUAL',
            'orden'                     => '3',       
        ]);                                                
    }
}
