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
        $admin_password = str_random(8);
        DB::table('users')->insert([
            'name' => 'CubeAdmin',
            'email' => 'admin@cubeupload.com',
            'password' => app('hash')->make($admin_password),
            'registration_ip' => '127.0.0.1',
            'access_level' => 9
        ]);

        echo "CubeAdmin user created with password ", $admin_password, "\n";
    }
}
