<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// ça remplie la bdd
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        User::withoutEvents(function(){
            //create 1
            User::factory()->count(2)->create([
                "role" => "admin"
            ]);

            //create 2
            User::factory()->count(2)->create([
                "role" => "redactor"
            ]);

            //create 3
            User::factory()->count(3)->create([
                "role" => "user"
            ]);
        });
        $nbUsers = 6;

        // Category        
        DB::table('categories')->insert([
            [
                "title" => "Category #1",
                "slug" => "category-#1"
            ],
            [
                "title" => "Category #2",
                "slug" => "category-#2"
            ],
            [
                "title" => "Category #3",
                "slug" => "category-#3"
            ],
        ]);
        $nbCategories = 3;

        // Tags
        DB::table('tags')->insert([
            ["tag" => "Tag1", "slug" => "tag1"],
            ["tag" => "Tag2", "slug" => "tag2"],
            ["tag" => "Tag3", "slug" => "tag3"],
            ["tag" => "Tag4", "slug" => "tag4"],
            ["tag" => "Tag5", "slug" => "tag5"],
            ["tag" => "Tag6", "slug" => "tag6"],
            ["tag" => "Tag7", "slug" => "tag7"],
            ["tag" => "Tag8", "slug" => "tag8"],
        ]);
        $nbTags = 8;

        // Posts
        Post::withoutEvents(function() {
            foreach (range(1, 3) as $i) {
                Post::factory()->create([
                    "title" => "Post" . $i,
                    "slug" => "post" . $i,
                    "seo_title" => "Post" . $i,
                    "user_id" => 2,
                    "image" => "img0" . $i . ".jpg",
                ]);
            }

            foreach (range(4, 10) as $i) {
                Post::factory()->create([
                    "title" => "Post" . $i,
                    "slug" => "post" . $i,
                    "seo_title" => "Post" . $i,
                    "user_id" => 3,
                    "image" => "img0" . $i . ".jpg",
                ]);
            }
        });
        $nbPosts = 10;

        // Tags attachement
        $posts = Post::all();
        foreach ($posts as $post) {
            if($post->id === 9){
                $nums = [1, 2, 3, 4, 5];
                $n = 4;
            }else{
                $nums = range(1, $nbTags);
                shuffle($nums);
                $n = rand(2, 4);
            }

            for ($i=0; $i < $n; $i++) { 
                $post->tags()->attach($nums[$i]);
            }
        }

        // Set categories
        foreach ($posts as $post) {
            if($post->id === 10){
                DB::table('category_post')->insert([
                    "category_id" => 1,
                    "post_id" => 10
                ]);
            }else{
                $nums = range(1, $nbCategories);
                shuffle($nums);
                $n = rand(1, 2);

                for ($i=0; $i < $n; $i++) { 
                    DB::table('category_post')->insert([
                        "category_id" => $nums[$i],
                        "post_id" => $post->id
                    ]);
                }
            }
        }

        // Comments
        foreach (range(1, $nbPosts - 1) as $i) {
            Comment::factory()->create([
                'post_id' => $i,
                'user_id' => rand(1, $nbUsers),
            ]);
        }

        $faker = \Faker\Factory::create();
        Comment::create([
            'post_id' => 2,
            'user_id' => 3,
            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
            'children' => [
                [
                    'post_id' => 2,
                    'user_id' => 4,
                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                    'children' => [
                        [
                            'post_id' => 2,
                            'user_id' => 2,
                            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                        ],
                    ],
                ],
            ],
        ]);
        Comment::create([
            'post_id' => 2,
            'user_id' => 6,
            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
            'children' => [
                [
                    'post_id' => 2,
                    'user_id' => 3,
                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                ],
                [
                    'post_id' => 2,
                    'user_id' => 6,
                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                    'children' => [
                        [
                            'post_id' => 2,
                            'user_id' => 3,
                            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                            'children' => [
                                [
                                    'post_id' => 2,
                                    'user_id' => 6,
                                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        Comment::create([
            'post_id' => 4,
            'user_id' => 4,
            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
            'children' => [
                [
                    'post_id' => 4,
                    'user_id' => 5,
                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                    'children' => [
                        [   'post_id' => 4,
                            'user_id' => 2,
                            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                        ],
                        [
                            'post_id' => 4,
                            'user_id' => 1,
                            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                        ],
                    ],
                ],
            ],
        ]);
    }
}
