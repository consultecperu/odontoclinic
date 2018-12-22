<?php

use Illuminate\Database\Seeder;
use App\Horario;

class HorariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Horario::create([
            'nombre_horario'        => 'Mañana',
            'inicio'                => '09:00',
            'fin'                   => '13:00'         
        ]);
        Horario::create([
            'nombre_horario'        => 'Tarde',
            'inicio'                => '15:00',
            'fin'                   => '20:00'         
        ]);    
        Horario::create([
            'nombre_horario'        => 'Noche',
            'inicio'                => '21:00',
            'fin'                   => '23:00'         
        ]);               
    }
}
