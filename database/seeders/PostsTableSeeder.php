<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Faker\Factory;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 posts using Faker library
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $imageCategory = $faker->randomElement(['cats', 'nature']);
            $imagePath = $faker->image('public/images/posts/image', 640, 480, $imageCategory, true);
            $imageName = basename($imagePath);

            Post::create([
                'user_id' => $faker->numberBetween(1, 10),
                'post_text' => $faker->realText(200),
                'image' => $imageName,
                'video' => $faker->url(),
                'post_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'update_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'visibility' => $faker->randomElement([0, 1]),
            ]);
        }
    }
}
