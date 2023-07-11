<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach(range(1,100) as $indexes){
            DB::table('posts')->insert([
                'user_slno'=>$faker->numberBetween(8, 12),
                'user_post'=>$faker->paragraph(),
                'viewed'=>$faker->randomNumber(),
                'total_comments'=>$faker->randomNumber(),
                'like_amount'=>$faker->randomNumber(),
                'creating_time'=>$faker->date(),
                'dislike_amount'=>$faker->randomNumber(),
                'problem_type'=> $faker->randomElement(['Php', 'Laravel', 'Python', 'Node Js', 'React js']),
                'intro'=>$faker->sentence()

            ]);
        }
    }
}
