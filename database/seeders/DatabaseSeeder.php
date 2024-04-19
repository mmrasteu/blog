<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        // Llamar al seeder
        $this->call(UserSeeder::class);

        // Factories
        Category::factory(8)->create();
        Article::factory(20)->create();
        Comment::factory(10)->create();

    }
}
