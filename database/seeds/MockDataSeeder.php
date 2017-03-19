<?php

use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\User;
use App\Models\Image;

class MockDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 10)->create();

        $users->each(function($u){
            $albums = $u->albums()->saveMany(factory(Album::class, 10)->create());
            $albums->each(function($a){
                $a->images()->saveMany(factory(Image::class, 20)->create());
            });
        });
    }
}
