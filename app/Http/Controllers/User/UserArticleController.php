<?php

namespace App\Http\Controllers\User;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\UserArticleResource;

class UserArticleController extends Controller
{
    public function index()
    {
        $data = Article::latest()->get();
        return ResponseController::create(UserArticleResource::collection($data), 'success', 'Data retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string|unique:articles",
            "description" => "required|string",
            "image" => "required|image",
            "publish_date" => "required|date",
            "isHeader" => "required|boolean",
            "isActive" => "boolean",
        ]);
        $validated["slug"] = Str::slug($validated["title"]);
        $extension = $request->file('image')->getClientOriginalExtension();
        $validated["image"] = $request->file("image")->storePubliclyAs("article", $validated["slug"] . ".$extension", "public");

        try {
            $article = Article::create($validated);
            return ResponseController::create(new UserArticleResource($article), "Created", "successfully saved data", 201);
        } catch (\Throwable $th) {
            return ResponseController::create(["error" => $th->getMessage()], "Internal Server Error", "Terjadi kesalahan pada server", 500);
        }
    }

    public function show(Article $article)
    {
        return ResponseController::create(new UserArticleResource($article), 'success', 'Data retrieved successfully', 200);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            "title" => "required|string|unique:articles,title,$article->id",
            "description" => "required|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg",
            "isActive" => "required|boolean",
            "isHeader" => "required|boolean",
            "publish_date" => "required|date",
        ]);
        $validated["slug"] = Str::slug($validated["title"]);

        if ($request->file("image")) {
            if ($article->image && Storage::exists($article->image)) {
                Storage::delete($article->image);
                $extension = $request->file('image')->getClientOriginalExtension();
            }
            $validated["image"] = $request->file("image")->storePubliclyAs("article", $validated["slug"] . ".$extension", "public");
        } else if ($request->title != $article->title) {
            // jika mnegganti title ganti nama file photo
            $extension = pathinfo(Storage::url($article->image), PATHINFO_EXTENSION);
            $fileName = $validated["slug"] . ".$extension";
            $filePath = "article/$fileName";
            Storage::move($article->image, $filePath);
            $validated["image"] = $filePath;
        } else {
            unset($validated["image"]);
        }
        try {
            $article->update($validated);
            return ResponseController::create(new UserArticleResource($article), "Success", "Data successfully updated", 200);
        } catch (\Throwable $th) {
            return ResponseController::create(["error" => $th->getMessage()], "Internal Server Error", "Terjadi kesalahan pada server", 500);
        }
    }

    public function destroy(Article $article)
    {
        try {
            if ($article->image && Storage::exists($article->image)) {
                Storage::delete($article->image);
            }
            $article->delete();
            return ResponseController::create("", "Success", "Data successfully deleted", 200);
        } catch (\Throwable $th) {
            return ResponseController::create(["error" => $th->getMessage()], "Internal Server Error", "Terjadi kesalahan pada server", 500);
        }
    }
}
