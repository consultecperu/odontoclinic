<?php

use Illuminate\Database\Seeder;
use App\Motivocaptacion;

class CaptacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'RECOMENDACIÓN DE FAMILIAR Y AMIGOS'                 
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'SEGUROS'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'CAMPAÑA EN EMPRESA O  CENTRO DE ESTUDIOS'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'VOLANTE'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'VIVO O TRABAJO CERCA'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'REINGRESO'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'CORREO ELECTRÓNICO'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'ANUNCIO EN FACEBOOK'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'CANJE'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'MULTIDENT CARD'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'PAGINA WEB'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'PLAN DENTAL'                 
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'EMERGENCIA'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'RADIO TV Y PRENSA ESCRITA'                 
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'CONVENIO'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'ANUNCIO EN GOOGLE'                 
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'LETRERO'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'BUSQUEDA GOOGLE'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'INSTAGRAM'                  
        ]);
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'OTROS'                  
        ]); 
        Motivocaptacion::create([
            'nombre_motivocaptacion'     => 'MARCA'                  
        ]);                                                                                                                                                                                 
    }
}
