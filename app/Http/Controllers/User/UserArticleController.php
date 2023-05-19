<?php

namespace App\Http\Controllers\User;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\ResponseController;

class UserArticleController extends Controller
{
    public function index () {
        $data = Article::latest()->get();
        return ResponseController::create($data, 'success', 'Data retrieved successfully', 200);
    }

    public function store (Request $request) {
        $validated = $request->validate([
            "title" => "required|string|unique:articles",
            "description" => "required|string",
            "isHeader" => "required|boolean",
            "image" => "required|image|mimes:jpeg,png,jpg",
            "isActive" => "boolean",
            "publish" => "required|date_format:Y-m-d H:i:s",
        ]);
        $validated["slug"] = Str::slug($validated["title"]);
        $extension = $request->file('image')->getClientOriginalExtension();
        $validated["image"] = basename($request->file("image")->storeAs("article", $validated["slug"] . ".$extension"));
        
        Article::create($validated);
        return ResponseController::create("", "Created", "successfully saved data", 201);
    }

    public function show (Article $article) {
        return ResponseController::create($article, 'success', 'Data retrieved successfully', 200);
    }

    public function update (Request $request, Article $article) {
        $validated = $request->validate([
            "title" => "required|string|unique:articles,title,$article->id",
            "description" => "required|string",
            "isHeader" => "required|boolean",
            "image" => "image|mimes:jpeg,png,jpg",
            "isActive" => "required|boolean",
            "publish" => "required|date_format:Y-m-d H:i:s",
        ]);
        $validated["slug"] = Str::slug($validated["title"]);

        if($request->file("image")){
            Storage::delete("article/$article->photo");
            $validated["image"] = basename($request->file("image")->storeAs("article", $validated["slug"] . ".jpg"));
        }
        $article->update($validated);
        return ResponseController::create("", "Success", "Data successfully updated", 200);
    }

    public function destroy (Article $article) {
        Storage::delete("article/$article->image");
        $article->delete();
        return ResponseController::create("", "Success", "Data successfully deleted", 200);
    }
}
