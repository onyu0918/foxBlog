<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use Database\Factories\BlogFactory;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Blog::factory(15)->create();
        //factory(Blog::class, 15)->create();
        // Blog::BlogFactory()
        //     ->count(15)
        //     ->create();
    }
}
