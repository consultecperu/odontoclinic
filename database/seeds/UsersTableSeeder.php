<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

/*         DB::table('users')->insert([
            'name'                  => 'aayala',
            'email'                 => 'aayala@gmail.com',
            'password'              => bcrypt('secret'),
            'perfil_id'             => 1,
            'acceso'                => true ,
            'activo'                => true ,
            'fecha_vencimiento'     => Carbon::now()->format('Y-m-d H:i:s')
        ]); */
        DB::table('users')->insert([
            'name'                  => 'jayala',
            'email'                 => 'jayala@gmail.com',
            'password'              => bcrypt('daniela'),
            'perfil_id'             => 1,
            'acceso'                => true ,
            'activo'                => true ,
            'fecha_vencimiento'     => Carbon::now()->format('Y-m-d H:i:s')
        ]);                
    }
}
