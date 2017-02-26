<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'CubeAdmin',
            'email' => 'admin@cubeupload.com',
            'password' => app('hash')->make('cubeupload'),
            'registration_ip' => '127.0.0.1'
        ]);
    }
}
