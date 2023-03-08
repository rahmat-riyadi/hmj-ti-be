<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleDetailResource;
use App\Http\Controllers\API\ResponseController;

class ArticleController extends Controller
{
    public function index () {
      $data = Article::where('isActive', 1)->latest()->get();
      return ResponseController::create(ArticleResource::collection($data), 'success', 'Data retrieved successfully', 200);
    }

    public function show (Article $article) {
      return ResponseController::create(new ArticleDetailResource($article), 'success', 'Data retrieved successfully', 200);
    }
}
