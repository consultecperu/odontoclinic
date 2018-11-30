<?php

use Illuminate\Database\Seeder;
use App\Perfile;

class PerfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfile::create([
            'nombre_perfil'     => 'Administrador',
            'descripcion'       => 'admin del sistema | control total',
            'habilitado'        => true,
            'activo'            => true                      
        ]);
    }
}
