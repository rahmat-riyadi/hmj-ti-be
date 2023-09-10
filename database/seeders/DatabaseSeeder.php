<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use App\Models\Business;
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

        // business
        Business::create([
            "title" => "Jasa Titip Bayar SPP",
            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias quos illo consequatur, officiis quas dolore!",
            "price" => "10.000",
            "isActive" => 1,
            "image" => "sadsdafds.jpg",
        ]);
        Business::create([
            "title" => "Jasa Titip Absen",
            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias quos illo consequatur, officiis quas dolore!",
            "price" => "15.000",
            "isActive" => 0,
            "image" => "sadsdafds.jpg",
        ]);
        Business::create([
            "title" => "Jasa Joki Laporan",
            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias quos illo consequatur, officiis quas dolore!",
            "price" => "40.000",
            "isActive" => 0,
            "image" => "sadsdafds.jpg",
        ]);
        Business::create([
            "title" => "Jasa Joki Tugas",
            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias quos illo consequatur, officiis quas dolore!",
            "price" => "35.000",
            "isActive" => 1,
            "image" => "sadsdafds.jpg",
        ]);

    }
}
