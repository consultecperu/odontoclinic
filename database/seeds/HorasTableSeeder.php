<?php

use Illuminate\Database\Seeder;
use App\Hora;

class HorasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hora::create(['nombre_hora'=> '08:00', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '08:30', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '09:00', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '09:30', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '10:00', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '10:30', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '11:00', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '11:30', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '12:00', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '12:30', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '13:00', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '13:30', 'turno' => 1]);
        Hora::create(['nombre_hora'=> '14:00', 'turno' => 1]);

        Hora::create(['nombre_hora'=> '14:00', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '14:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '15:00', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '15:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '16:00', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '16:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '17:00', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '17:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '18:00', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '18:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '19:00', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '19:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '20:00', 'turno' => 2]); 
        Hora::create(['nombre_hora'=> '20:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '21:00', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '21:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '22:00', 'turno' => 2]); 
        Hora::create(['nombre_hora'=> '22:30', 'turno' => 2]);
        Hora::create(['nombre_hora'=> '23:00', 'turno' => 2]);                      
    }
}
