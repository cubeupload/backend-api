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
            'registration_ip' => '127.0.0.1',
            'access_level' => 9
        ]);

        DB::table('users')->insert([
            'name' => 'Test Moderator',
            'email' => 'testmod@cubeupload.com',
            'password' => app('hash')->make(str_random(12)),
            'registration_ip' => '127.0.0.1',
            'access_level' => 5
        ]);

        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'testuser@cubeupload.com',
            'password' => app('hash')->make(str_random(12)),
            'registration_ip' => '127.0.0.1',
            'access_level' => 1
        ]);
    }
}
