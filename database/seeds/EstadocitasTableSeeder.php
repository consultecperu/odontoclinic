<?php

use Illuminate\Database\Seeder;
use App\Estadocita;

class EstadocitasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estadocita::create([
            'nombre_estadocita'         => 'Citado',
            'orden'                     => 1 ,
            'color'                     => '#A9B6F7',
            'color_disabled'            => '#B3DCEC',
            'color_font'                => '#000000',
            'color_border'              => '#373AD7',

        ]);
        Estadocita::create([
            'nombre_estadocita'         => 'En sala de espera',
            'orden'                     => 2 ,
            'color'                     => '#FCFD95',
            'color_disabled'            => '#ffffd2',
            'color_font'                => '#000000',
            'color_border'              => '#D4AF2D',

        ]);
        Estadocita::create([
            'nombre_estadocita'         => 'En consulta',
            'orden'                     => 3 ,
            'color'                     => '#FFB878',
            'color_disabled'            => '#ffd191',
            'color_font'                => '#000000',
            'color_border'              => '#D8891A',

        ]);
        Estadocita::create([
            'nombre_estadocita'         => 'Atendido',
            'orden'                     => 4 ,
            'color'                     => '#51B749',
            'color_disabled'            => '#ABD79A',
            'color_font'                => '#000000',
            'color_border'              => '#368C15',

        ]);
        Estadocita::create([
            'nombre_estadocita'         => 'Cancelado',
            'orden'                     => 5 ,
            'color'                     => '',
            'color_disabled'            => '',
            'color_font'                => '',
            'color_border'              => '',

        ]);
        Estadocita::create([
            'nombre_estadocita'         => 'NSP',
            'orden'                     => 6 ,
            'color'                     => '#d76e75',
            'color_disabled'            => '#EBB7BA',
            'color_font'                => '#000000',
            'color_border'              => '#B50005',

        ]);                                        
    }
}
