<?php

namespace App\Http\Controllers\Guest;

use App\Models\Article;
use App\Models\Business;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\CarouselResource;
use App\Http\Controllers\API\ResponseController;

class HomeController extends Controller
{
    public function carousel()
    {
        $data = Article::where('isHeader', 1)->where('isActive', 1)->latest()->get();
        return ResponseController::create(CarouselResource::collection($data), 'success', 'Data retrieved successfully', 200);
    }
    public function article()
    {
        $data = Article::where('isActive', 1)->latest()->limit(3)->get();
        return ResponseController::create(ArticleResource::collection($data), 'success', 'Data retrieved successfully', 200);
    }
    public function business()
    {
        $data = Business::where('isActive', 1)->latest()->limit(2)->get();
        return ResponseController::create(BusinessResource::collection($data), 'success', 'Data retrieved successfully', 200);
    }
    public function storeComplaint(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "email" => "nullable|email",
            "phone" => "nullable|^08[0-9]{8,11}$/",
            "institute" => "nullable|string",
            "description" => "required|string",
        ]);
        try {
            Complaint::create($validated);
            return ResponseController::create("", "Created", "Pesan Berhasil Dikirim", 201);
        } catch (\Throwable $th) {
            return ResponseController::create(["error" => $th->getMessage()], "Internal Server Error", "Terjadi kesalahan pada server", 500);
        }
    }
}
