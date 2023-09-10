<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "slug" => $this-> slug,
            "title" => $this->title,
            "description" => $this->description,
            "image" => url("storage/".$this->image),
            "publish_date" => $this->publish_date,
            "isActive" => $this->isActive,
            "isHeader" => $this->isHeader,
        ];
    }
}
