<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('posts');
        Storage::makeDirectory('posts');
        User::create([
            'name' => 'Fernando Rubio',
            'email' => 'fer@gmail.com',
            'password' => bcrypt('123123'),
        ]);
        Post::factory(50)->create();


    }
}
