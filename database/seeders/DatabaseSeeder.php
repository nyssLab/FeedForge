<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Post::factory(5))
            ->create();

        User::factory()
            ->has(Post::factory(5))
            ->create([
                'username' => 'testUser',
                'email' => 'test@example.com',
            ]);
    }
}
