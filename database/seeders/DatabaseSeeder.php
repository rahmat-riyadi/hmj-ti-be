<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use App\Models\Business;
use App\Models\Complaint;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "username" => "user1",
            "email" => "user1@gmail.com",
            "password" => bcrypt('password'),
        ]);

        Article::factory()->count(10)->create();
        Complaint::factory()->count(10)->create();
        $this->call(BusinessSeeder::class);
    }
}
