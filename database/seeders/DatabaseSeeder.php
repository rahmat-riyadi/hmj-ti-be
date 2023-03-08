<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\Business;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // article
        Article::create([
            "title" => "Artikel 1",
            "slug" => "artikel-1",
            "description" => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error harum unde esse aliquid. Beatae, ut.</p>",
            "isHeader" => 1,
            "image" => "dasdasda.jpg",
            "isActive" => 1,
            "publish" => Carbon::now(),
        ]);
        Article::create([
            "title" => "Artikel 2",
            "slug" => "artikel-2",
            "description" => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error harum unde esse aliquid. Beatae, ut.</p>",
            "isHeader" => 1,
            "image" => "dasdasda.jpg",
            "isActive" => 0,
            "publish" => Carbon::now(),
        ]);
        Article::create([
            "title" => "Artikel 3",
            "slug" => "artikel-3",
            "description" => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error harum unde esse aliquid. Beatae, ut.</p>",
            "isHeader" => 0,
            "image" => "dasdasda.jpg",
            "isActive" => 1,
            "publish" => Carbon::now(),
        ]);
        Article::create([
            "title" => "Artikel 4",
            "slug" => "artikel-4",
            "description" => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error harum unde esse aliquid. Beatae, ut.</p>",
            "isHeader" => 1,
            "image" => "dasdasda.jpg",
            "isActive" => 1,
            "publish" => Carbon::now(),
        ]);
        Article::create([
            "title" => "Artikel 5",
            "slug" => "artikel-5",
            "description" => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error harum unde esse aliquid. Beatae, ut.</p>",
            "isHeader" => 0,
            "image" => "dasdasda.jpg",
            "isActive" => 1,
            "publish" => Carbon::now(),
        ]);

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

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
