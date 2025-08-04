<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create admin
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
        ]);

        // Create Categories
        $categories = \App\Models\Category::factory(5)->create();


        $faker = Faker::create();

        $tagNames = collect(range(1, 5))->map(fn() => $faker->unique()->word());

        $tagNames = ['Laravel', 'Vue', 'Livewire', 'Backend', 'Frontend'];
        $tags = collect($tagNames)->map(fn($name) => \App\Models\Tag::findOrCreate($name));

        $users = \App\Models\User::factory(10)->create();

        // Create posts
        \App\Models\Post::factory(100)->create()->each(function ($post) use ($categories, $tags, $users) {
            // Attach 1-3 random categories
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Assign some tags
            $post->attachTags($tags->random(rand(1, 2))->pluck('name')->toArray());

            // Optionally assign to admin
            $post->author()->associate($users->random())->save();

            // Add comments by random users
            \App\Models\Comment::factory(rand(2, 6))->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ]);
        });

    }
}
