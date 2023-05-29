<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseUrl = Config::get('app.url');
        return [
            "id" => $this->id,
            "slug" => $this->slug,
            "title" => $this->title,
            "description" => $this->description,
            // "image" => "$baseUrl/storage/$this->image",
            "image" => url("storage/$this->image"),
        ];
    }
}
